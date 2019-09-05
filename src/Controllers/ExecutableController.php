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
use PandoApps\Quiz\Helpers\Helpers;
use PandoApps\Quiz\Services\ExecutionTimeService;

class ExecutableController extends Controller
{
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
     * @param int $idQuestionnaire
     * @param int $modelId
     * @return \Illuminate\Http\Response
     */
    public function create($parentId, $idQuestionnaire, $modelId, ExecutionTimeService $executionTimeService)
    {
        $questionnaire = Questionnaire::with(['questions' => function ($query) {
            $query->where('is_active', 1);
        }, 'questions.alternatives'])
                                        ->find($idQuestionnaire);
        if (empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();

            return redirect(route('executables.index', ['parent_id' => $parentId, 'questionnaire_id' => $idQuestionnaire, 'model_id' => $modelId]));
        }
        
        if (!$executionTimeService->canExecutionAgain($questionnaire, $modelId)) {
            return redirect()->back();
        }
        
        if ($questionnaire->answer_once) {
            $executionModelCount = $executionsModel->count();
            if ($executionModelCount > 1) {
                flash('Questionário só pode ser respondido uma vez!')->error();

                return redirect(route('questionnaires.index', $parentId));
            }
        }
        
        if ($questionnaire->execution_time) {
            $executionTime = Helpers::handlePlusTime(now(), $questionnaire->type_execution_time, $questionnaire->execution_time);
            $executionTimeService->handleQuestionnaireExecutionTime();
            return view('pandoapps::executables.create', compact('questionnaire', 'modelId', 'executionTime'));
        }

        return view('pandoapps::executables.create', compact('questionnaire', 'modelId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except('_token');
        
        $executable = Executable::create([
            'executable_id'         => $request->model_id,
            'executable_type'       => config('quiz.models.executable'),
            'questionnaire_id'      => $request->questionnaire_id,
            'score'                 => 0
        ]);
        
        $sumWeight = 0;
        $sumValues = 0;
        foreach ($input as $idQuestion => $answer) {
            $question = Question::find($idQuestion);
            
            if ($question->question_type_id == config('quiz.question_types.CLOSED.id')) {
                $alternative = Alternative::find($answer);
                
                if ($alternative->is_correct) {
                    $score = $question->weight * $alternative->value;
                    $sumValues += $question->weight * $alternative->value;
                    $sumWeight += $question->weight;
                } else {
                    $score = 0;
                }
                
                Answer::create([
                    'executable_id'      => $executable->id,
                    'alternative_id'    => $answer,
                    'question_id'       => $idQuestion,
                    'score'             => $score,
               ]);
            } else {
                $sumValues = null;
                $sumWeight = null;
                Answer::create([
                    'executable_id'      => $executable->id,
                    'alternative_id'    => null,
                    'question_id'       => $idQuestion,
                    'description'       => $answer,
                    'score'             => null
               ]);
            }
        }
        
        if ($sumValues && $sumWeight) {
            $scoreTotal = $sumValues / $sumWeight;
            $executable->update(['score' => $scoreTotal]);
        }
        
        flash('Questionário respondido com sucesso!')->success();
        
        return redirect(route('executables.index', ['parent_id' => $request->parent_id, 'questionnaire_id' => $request->questionnaire_id, 'model_id' => $request->model_id]));
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
}
