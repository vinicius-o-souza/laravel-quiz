<?php

namespace PandoApps\Quiz\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use PandoApps\Quiz\Models\Alternative;
use PandoApps\Quiz\Models\Execution;
use PandoApps\Quiz\Models\Question;
use PandoApps\Quiz\Models\Questionnaire;
use PandoApps\Quiz\DataTables\QuestionnaireDataTable;
use Auth;

class QuestionnaireController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param QuestionnaireDataTable $questionnaireDataTable
     * @return \Illuminate\Http\Response
     */
    public function index(QuestionnaireDataTable $questionnaireDataTable)
    {
        return $questionnaireDataTable->render('pandoapps::questionnaires.index');
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
        $input = $request->all();

        $questionnaireValidation = Validator::make($input, Questionnaire::$rules);
        if ($questionnaireValidation->fails()) {
            $errors = $questionnaireValidation->errors();
            $msg = '';
            foreach($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect()->back()->withInput();
        }
        
        DB::beginTransaction();

        $questionnaire = Questionnaire::create([
            'name'        => $input['name'],
            'answer_once' => isset($input['answer_once']) ? true : false
        ]);
        
        foreach(array_keys($input['description']) as $keyQuestion) {
            $question = Question::create([
                'description'       => $input['description'][$keyQuestion],
                'hint'              => isset($input['hint'][$keyQuestion]) ? $input['hint'][$keyQuestion] : null,
                'is_required'       => isset($input['is_required'][$keyQuestion]) ? true : false,
                'is_active'         => isset($input['is_active'][$keyQuestion]) ? true : false,
                'weight'            => $input['weight'][$keyQuestion],
                'question_type_id'  => $input['question_type_id'][$keyQuestion],
                'questionnaire_id'  => $questionnaire->id
            ]);
            
            if($question->question_type_id == config('quiz.question_types.CLOSED.id')) {
                if($input['countAlternatives'][$keyQuestion] > 0) {
                    foreach(array_keys($input['description_alternative'][$keyQuestion]) as $keyAlternative) {
                        Alternative::create([
                            'description'   => $input['description_alternative'][$keyQuestion][$keyAlternative],
                            'value'         => $input['value_alternative'][$keyQuestion][$keyAlternative],
                            'is_correct'    => isset($input['is_correct'][$keyQuestion][$keyAlternative]) ? true : false,
                            'question_id'   => $question->id,
                        ]);
                    }    
                } else {
                    flash('Questões fechadas devem ter no mínimo 1 alternativa')->error();
                    DB::rollback();
                    return redirect(route('questionnaires.create'));
                }   
            }    
        }
        
        DB::commit();

        flash('Questionário criado com sucesso!')->success();

        return redirect(route('questionnaires.index'));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $questionnaire = Questionnaire::find($id);

        if(empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();

            return redirect(route('questionnaires.index'));
        }

        return view('pandoapps::questionnaires.show', compact('questionnaire'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $questionnaire = Questionnaire::with('questions')->with('questions.alternatives')->find($id);

        if(empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();

            return redirect(route('questionnaires.index'));
        }

        return view('pandoapps::questionnaires.edit', compact('questionnaire'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $questionnaire = Questionnaire::find($id);

        if(empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();

            return redirect(route('questionnaires.index'));
        }

        $input = $request->all();

        $questionnaireValidation = Validator::make($input, Questionnaire::$rules);
        if ($questionnaireValidation->fails()) {
            $errors = $questionnaireValidation->errors();
            $msg = '';
            foreach($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect()->back()->withInput();
        }

        if(isset($input['answer_once'])) {
            $input['answer_once'] = true;
        } else {
            $input['answer_once'] = false;
        }
        
        $inputQuestionnaire = $request->only('name', 'answer_once');
        
        if(isset($input['answer_once'])) {
            $inputQuestionnaire['answer_once'] = true;
        } else {
            $inputQuestionnaire['answer_once'] = false;
        }
        
        $questionnaire->update($inputQuestionnaire);
        
        foreach(array_keys($input['description']) as $keyQuestion) {
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
            
            if($question->question_type_id == config('quiz.question_types.CLOSED.id')) {
                if($input['countAlternatives'][$keyQuestion] > 0) {
                    foreach(array_keys($input['description_alternative'][$keyQuestion]) as $keyAlternative) {
                        Alternative::updateOrCreate(
                            [
                                'id'            => $keyAlternative,
                                'question_id'   => $question->id
                            ],    
                            [
                                'description'   => $input['description_alternative'][$keyQuestion][$keyAlternative],
                                'value'         => $input['value_alternative'][$keyQuestion][$keyAlternative],
                                'is_correct'    => isset($input['is_correct'][$keyQuestion][$keyAlternative]) ? true : false,
                            ]
                        );
                    }    
                } else {
                    flash('Questões fechadas devem ter no mínimo 1 alternativa')->error();
                    DB::rollback();
                    return redirect(route('questionnaires.create'));
                }   
            }    
        }

        flash('Questionário atualizado com sucesso!')->success();

        return redirect(route('questionnaires.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $questionnaire = Questionnaire::find($id);

        if(empty($questionnaire)) {
            flash('Questionário não encontrado!')->error();

            return redirect(route('questionnaires.index'));
        }

        $questionnaire->delete();

        flash('Questionário deletado com sucesso!')->success();

        return redirect(route('questionnaires.index'));
    }
}
