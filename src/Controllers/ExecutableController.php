<?php

namespace PandoApps\Quiz\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PandoApps\Quiz\DataTables\ExecutableDataTable;
use PandoApps\Quiz\Models\Alternative;
use PandoApps\Quiz\Models\Answer;
use PandoApps\Quiz\Models\Executable;
use PandoApps\Quiz\Models\Question;
use PandoApps\Quiz\Models\Questionnaire;
use PandoApps\Quiz\Services\ExecutionTimeService;

class ExecutableController extends Controller
{
    private $parentName;

    public function __construct()
    {
        $this->parentName = config('quiz.models.parent_id');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param ExecutableDataTable $executableDataTable
     * @return \Illuminate\Http\Response
     */
    public function index(ExecutableDataTable $executableDataTable)
    {
        return $executableDataTable->render('pandoapps::executables.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $parentId
     * @param int $questionnaireId
     * @param int $modelId
     * @return \Illuminate\Http\Response
     */
    public function create($parentId, $questionnaireId, $modelId, ExecutionTimeService $executionTimeService)
    {
        $questionnaire = Questionnaire::with(['questions' => function ($query) {
            $query->where('is_active', 1)->orderByRaw('RAND()');
        }, 'questions.alternatives'])->find($questionnaireId);
        
        if (empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();
            return redirect(route('executables.index', ['parent_id' => $parentId, 'questionnaire_id' => $questionnaireId, 'model_id' => $modelId]));
        }

        $executionTimeService->handleIfHasExecutableNotAnswered($questionnaire, $modelId);
        
        if ($questionnaire->answer_once) {
            $executionsModel = $questionnaire->executables()->where('executable_id', $modelId)->orderBy('pivot_created_at', 'desc')->get();
            $executionModelCount = $executionsModel->count();
            if ($executionModelCount > 1) {
                flash('Questionário só pode ser respondido uma vez!')->error();
                return redirect(route('questionnaires.index', $parentId));
            }
        }
        
        if (!$questionnaire->canExecute($modelId)) {
            flash('Questionário pode ser respondido novamente '. $questionnaire->timeToExecuteAgain($modelId) .'!')->error();
            return redirect(route('executables.index', ['parent_id' => $parentId, 'questionnaire_id' => $questionnaireId, 'model_id' => $modelId]));
        }

        return view('pandoapps::executables.create', compact('questionnaire', 'modelId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ExecutionTimeService $executionTimeService)
    {
        $parentName = $this->parentName;
        $input = $request->except(['_token', 'model_id', 'questionnaire_id']);
        
        $variables = $request->only(['model_id', 'questionnaire_id']);
        $modelId = $variables['model_id'];
        $questionnaireId = $variables['questionnaire_id'];
        
        $questionnaire = Questionnaire::find($questionnaireId);
        
        if (empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();
            return redirect(route('executables.index', ['parent_id' => $request->$parentName, 'questionnaire_id' => $questionnaireId, 'model_id' => $modelId]));
        }
        
        if (!$questionnaire->canExecute($modelId)) {
            flash('Questionário pode ser respondido novamente '. $questionnaire->timeToExecuteAgain($modelId) .'!')->error();
            return redirect(route('executables.index', ['parent_id' => $request->$parentName, 'questionnaire_id' => $questionnaireId, 'model_id' => $modelId]));
        }
        
        $executable = Executable::whereNull('answered')->where('questionnaire_id', $questionnaireId)
                                ->where('executable_id', $modelId)
                                ->where('executable_type', config('quiz.models.executable'))->first();

        if (empty($executable)) {
            flash('Ocorreu um erro ao tentar submeter o questionário!')->error();
            return redirect(route('executables.index', ['parent_id' => $request->$parentName, 'questionnaire_id' => $questionnaireId, 'model_id' => $modelId]));
        }
        
        $sumValues = 0;
        $sumWeight = 0;
        if($input) {
            foreach ($input as $idQuestion => $answer) {
                $question = Question::find($idQuestion);
                
                if ($question->question_type_id == config('quiz.question_types.CLOSED.id')) {
                    $alternative = Alternative::find($answer);
                    
                    if ($alternative->is_correct) {
                        $score = $question->weight * $alternative->value;
                        $sumValues += $question->weight * $alternative->value;
                    } else {
                        $score = 0;
                    }
                    $sumWeight += $question->weight;
                    
                    Answer::create([
                        'executable_id'      => $executable->id,
                        'alternative_id'    => $answer,
                        'question_id'       => $idQuestion,
                        'score'             => $score,
                   ]);
                } else {
                    $sumValues = null;
                    Answer::create([
                        'executable_id'      => $executable->id,
                        'alternative_id'    => null,
                        'question_id'       => $idQuestion,
                        'description'       => $answer,
                        'score'             => null
                   ]);
                }
            }
            
            if ($sumValues) {
                $scoreTotal = $sumValues / $sumWeight;
            } else {
                $scoreTotal = 0;
            }
            $executable->update([
                'score'     => $scoreTotal,
                'answered'  => true
            ]);
        } else {
            $executable->update([
                'score'     => 0,
                'answered'  => false
            ]);
        }
        
        $executionTimeService->deleteRedisKey($questionnaire, $modelId);
        
        flash('Questionário respondido com sucesso!')->success();
        
        return redirect(route('executables.index', ['parent_id' => $request->$parentName, 'questionnaire_id' => $questionnaireId, 'model_id' => $modelId]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $parentId
     * @return \Illuminate\Http\Response
     */
    public function show($parentId, $executableId)
    {
        $executable = Executable::with('answers.question')->find($executableId);
        
        if (empty($executable)) {
            flash('Execução do questionário não encontrada!')->error();

            if (request()->model_id) {
                return redirect(route('executables.show', ['parent_id' => $parentId, 'model_id' => request()->model_id]));
            }
            return redirect(route('executables.index', $parentId));
        }
        
        return view('pandoapps::executables.show', compact('executable'));
    }

    /**
     * Create a executable if start a executable
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $questionnaireId
     * @return \Illuminate\Http\Response
     */
    public function handleStartExecutable(Request $request, $questionnaireId, ExecutionTimeService $executionTimeService)
    {
        $parentName = $this->parentName;
        $input = $request->all();
        
        $questionnaire = Questionnaire::find($questionnaireId);
        
        if (empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();
            return redirect(route('executables.index', ['parent_id' => $request->$parentName, 'questionnaire_id' => $questionnaireId, 'model_id' => $input['model_id']]));
        }
        
        $executable = Executable::whereNull('answered')->where('questionnaire_id', $questionnaireId)
                                ->where('executable_id', $input['model_id'])
                                ->where('executable_type', config('quiz.models.executable'))->first();

        if (empty($executable)) {
            $executable = Executable::create([
                'executable_id'         => $input['model_id'],
                'executable_type'       => config('quiz.models.executable'),
                'questionnaire_id'      => $questionnaireId,
                'score'                 => 0,
                'answered'              => null
            ]);
        }
        
        if ($questionnaire->execution_time) {
            $executionTime = $executionTimeService->startRedisCache($questionnaire, $input['model_id']);
            return response()->json([
                'status'            => 'success',
                'executionTime'     => $executionTime
            ], 200);
        }
        
        return response()->json([
            'status'            => 'success',
        ], 200);
    }
}
