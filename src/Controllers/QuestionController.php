<?php

namespace PandoApps\Quiz\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use PandoApps\Quiz\Models\Question;
use PandoApps\Quiz\Models\QuestionType;
use PandoApps\Quiz\DataTables\QuestionDataTable;

class QuestionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param QuestionDataTable $questionDataTable
     * @return \Illuminate\Http\Response
     */    
    public function index(QuestionDataTable $questionDataTable)
    {
        return $questionDataTable->render('pandoapps::questions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questionsType = QuestionType::orderBy('name','asc')->pluck('name','id')->toArray();

        return view('pandoapps::questions.create', compact('questionsType'));
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

        $questionValidation = Validator::make($input, Question::$rules);
        if ($questionValidation->fails()) {
            $errors = $questionValidation->errors();
            $msg = '';
            foreach($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect()->back()->withInput();
        }

        Question::create([
            'title'            => $input['title'],
            'description'      => $input['description'],
            'hint'             => isset($input['hint']) ? $input['hint'] : '',
            'is_required'      => isset($input['is_required']) ? true : '',
            'questionnaire_id' => request()->questionnaire_id,
            'question_type_id' => $input['question_type_id'],
        ]);

        flash('Questão criada com sucesso!')->success();

        return redirect(route('questions.index', request()->questionnaire_id));
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);

        if(empty($question)) {
            flash('Questão não encontrada!')->error();

            return redirect(route('questions.index'));
        }

        return view('pandoapps::questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);

        $questionsType = QuestionType::orderBy('name','asc')->pluck('name','id')->toArray();

        if(empty($question)) {
            flash('Questão não encontrada!')->error();

            return redirect(route('questions.index'));
        }

        return view('pandoapps::questions.edit', compact('question', 'questionsType'));
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
        $question = Question::find($id);

        if(empty($question)) {
            flash('Questão não encontrada!')->error();

            return redirect(route('questions.index'));
        }

        $input = $request->all();

        $questionValidation = Validator::make($input, Question::$rules);
        if ($questionValidation->fails()) {
            $errors = $questionValidation->errors();
            $msg = '';
            foreach($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect()->back()->withInput();
        }

        $question->update($input);

        flash('Questão atualizada com sucesso!')->success();

        return redirect(route('questions.index', request()->questionnaire_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);

        if(empty($question)) {
            flash('Questão não encontrada!')->error();

            return redirect(route('questions.index'));
        }

        $id = $question->id;
        $question->delete();

        if(request()->ajax()) {
            return response()->json(['status' => 'Questão deletada']);
        } 
        flash('Questão deletada com sucesso!')->success();

        return redirect(route('questions.index', request()->questionnaire_id));
    }
}
