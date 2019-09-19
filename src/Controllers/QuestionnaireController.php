<?php

namespace PandoApps\Quiz\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use PandoApps\Quiz\DataTables\QuestionnaireDataTableInterface;
use PandoApps\Quiz\Models\Alternative;
use PandoApps\Quiz\Models\Question;
use PandoApps\Quiz\Models\Questionnaire;
use PandoApps\Quiz\Helpers\Helpers;

class QuestionnaireController extends Controller
{
    private $questionnaireDataTableInterface;
    private $params;

    public function __construct(QuestionnaireDataTableInterface $questionnaireDataTableInterface)
    {
        $this->questionnaireDataTableInterface = $questionnaireDataTableInterface;
        $this->params = Helpers::getAllParameters();
        unset($this->params['questionnaire_id']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->questionnaireDataTableInterface->render('pandoapps::questionnaires.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pandoapps::questionnaires.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parentId = config('quiz.models.parent_id');
        $input = $request->all();

        $questionnaireValidation = Validator::make($input, Questionnaire::$rules);
        if ($questionnaireValidation->fails()) {
            $errors = $questionnaireValidation->errors();
            $msg = '';
            foreach ($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect(route('questionnaires.index', $this->params));
        }
        
        DB::beginTransaction();

        $questionnaire = Questionnaire::create([
            'name'                  => $input['name'],
            'answer_once'           => isset($input['answer_once']) ? true : false,
            'parent_id'             => $request->$parentId,
            'parent_type'           => config('quiz.models.parent_type'),
            'waiting_time'          => isset($input['waiting_time']) ? $input['waiting_time'] : null,
            'type_waiting_time'     => isset($input['type_waiting_time']) ? $input['type_waiting_time'] : null,
            'execution_time'        => isset($input['execution_time']) ? $input['execution_time'] : null,
            'type_execution_time'   => isset($input['type_execution_time']) ? $input['type_execution_time'] : null
        ]);
        
        if ($input['countQuestion'] > 0) {
            foreach (array_keys($input['description']) as $keyQuestion) {
                $question = Question::create([
                    'description'       => $input['description'][$keyQuestion],
                    'hint'              => isset($input['hint'][$keyQuestion]) ? $input['hint'][$keyQuestion] : null,
                    'is_required'       => isset($input['is_required'][$keyQuestion]) ? true : false,
                    'is_active'         => isset($input['is_active'][$keyQuestion]) ? true : false,
                    'weight'            => $input['weight'][$keyQuestion],
                    'question_type_id'  => $input['question_type_id'][$keyQuestion],
                    'questionnaire_id'  => $questionnaire->id
                ]);
                
                if ($question->question_type_id == config('quiz.question_types.CLOSED.id')) {
                    if ($input['countAlternatives'][$keyQuestion] > 0) {
                        foreach (array_keys($input['description_alternative'][$keyQuestion]) as $keyAlternative) {
                            $value = $input['value_alternative'][$keyQuestion][$keyAlternative];
                            if ($value < 0 || $value > 10) {
                                flash('Valor das alternativas deve ser no mínimo 0 ou no máximo 10')->error();        
                                DB::rollback();
                                return redirect(route('questionnaires.create', $this->params));
                            } else {
                                $is_correct = isset($input['is_correct'][$keyQuestion][$keyAlternative]);
                                if(!$is_correct) {
                                    $value = 0;
                                }
                                Alternative::create([
                                    'description'   => $input['description_alternative'][$keyQuestion][$keyAlternative],
                                    'value'         => $value,
                                    'is_correct'    => $is_correct ? true : false,
                                    'question_id'   => $question->id,
                                ]);   
                            }
                        }
                    } else {
                        flash('Questões fechadas devem ter no mínimo 1 alternativa')->error();
                        DB::rollback();
                        return redirect(route('questionnaires.create', $this->params));
                    }
                }
            }
        } else {
            flash('Questionário devem ter no mínimo 1 questão')->error();
            DB::rollback();
            return redirect(route('questionnaires.create', $this->params));
        }
        DB::commit();
        flash('Questionário criado com sucesso!')->success();
        return redirect(route('questionnaires.index', $this->params));
    }
    
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id = request()->questionnaire_id;
        $questionnaire = Questionnaire::find($id);

        if (empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();
            return redirect(route('questionnaires.index', $this->params));
        }

        return view('pandoapps::questionnaires.show', compact('questionnaire'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = request()->questionnaire_id;
        $questionnaire = Questionnaire::with('questions')->with('questions.alternatives')->find($id);

        if (empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();
            return redirect(route('questionnaires.index', $this->params));
        }

        return view('pandoapps::questionnaires.edit', compact('questionnaire'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->questionnaire_id;
        $questionnaire = Questionnaire::find($id);

        if (empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();
            return redirect(route('questionnaires.index', $this->params));
        }

        $input = $request->all();

        $questionnaireValidation = Validator::make($input, Questionnaire::$rules);
        if ($questionnaireValidation->fails()) {
            $errors = $questionnaireValidation->errors();
            $msg = '';
            foreach ($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect(route('questionnaires.index', $this->params));
        }

        if (isset($input['answer_once'])) {
            $input['answer_once'] = true;
        } else {
            $input['answer_once'] = false;
        }
        
        $inputQuestionnaire = $request->only('name', 'answer_once', 'waiting_time', 'type_waiting_time', 'execution_time', 'type_execution_time');
        
        if ($input['answer_once']) {
            $inputQuestionnaire['answer_once'] = true;
        } else {
            $inputQuestionnaire['answer_once'] = false;
        } 
                
        if(!isset($input['checkbox_waiting_time'])) {
            $inputQuestionnaire['waiting_time'] = null;
            $inputQuestionnaire['type_waiting_time'] = null;
        }
        
        if(!isset($input['checkbox_execution_time'])) {
            $inputQuestionnaire['execution_time'] = null;
            $inputQuestionnaire['type_execution_time'] = null;
        }
        
        $questionnaire->update($inputQuestionnaire);
        
        foreach (array_keys($input['description']) as $keyQuestion) {
            $question = Question::updateOrCreate(
                [
                    'id'                => $keyQuestion,
                    'questionnaire_id'  => $questionnaire->id
                ],
                [
                    'description'       => $input['description'][$keyQuestion],
                    'hint'              => isset($input['hint'][$keyQuestion]) ? $input['hint'][$keyQuestion] : null,
                    'is_required'       => isset($input['is_required'][$keyQuestion]) ? true : false,
                    'is_active'         => isset($input['is_active'][$keyQuestion]) ? true : false,
                    'weight'            => $input['weight'][$keyQuestion],
                    'question_type_id'  => $input['question_type_id'][$keyQuestion],
                ]
            );
            
            if ($question->question_type_id == config('quiz.question_types.CLOSED.id')) {
                if ($input['countAlternatives'][$keyQuestion] > 0) {
                    foreach (array_keys($input['description_alternative'][$keyQuestion]) as $keyAlternative) {
                        $value = $input['value_alternative'][$keyQuestion][$keyAlternative];
                        if ($value < 0 || $value > 10) {
                            flash('Valor das alternativas deve ser no mínimo 0 ou no máximo 10')->error();        
                            DB::rollback();
                            return redirect(route('questionnaires.create', $this->params));
                        } else {
                            $is_correct = isset($input['is_correct'][$keyQuestion][$keyAlternative]);
                            if(!$is_correct) {
                                $value = 0;
                            }
                            Alternative::updateOrCreate(
                                [
                                    'id'            => $keyAlternative,
                                    'question_id'   => $question->id
                                ],
                                [
                                    'description'   => $input['description_alternative'][$keyQuestion][$keyAlternative],
                                    'value'         => $value,
                                    'is_correct'    => $is_correct ? true : false,
                                ]
                            );
                        }
                    }
                } else {
                    flash('Questões fechadas devem ter no mínimo 1 alternativa')->error();
                    DB::rollback();
                    return redirect(route('questionnaires.create', $this->params));
                }
            }
        }
        flash('Questionário atualizado com sucesso!')->success();
        return redirect(route('questionnaires.index', $this->params));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = request()->questionnaire_id;
        $questionnaire = Questionnaire::find($id);

        if (empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();
            return redirect(route('questionnaires.index', $this->params));
        }
        $questionnaire->delete();
        flash('Questionário deletado com sucesso!')->success();
        return redirect(route('questionnaires.index', $this->params));
    }
}
