<?php

namespace PandoApps\Quiz\Controllers;

use PandoApps\Quiz\Models\Alternative;
use PandoApps\Quiz\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use PandoApps\Quiz\DataTables\AnswerDataTable;

class AnswerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param AnswerDataTable $answerDataTable
     * @return \Illuminate\Http\Response
     */
    public function index(AnswerDataTable $answerDataTable)
    {
        return $answerDataTable->render('pandoapps::answers.index');
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $alternatives = Alternative::where('question_id', request()->question_id)->orderBy('name','asc')->pluck('name','id')->toArray();

        return view('pandoapps::answers.create', compact('alternatives'));
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

        $answerValidation = Validator::make($input, Answer::$rules);
        if ($answerValidation->fails()) {
            $errors = $answerValidation->errors();
            $msg = '';
            foreach($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect()->back()->withInput();
        }

        Answer::create([
            'title'       => $input['title'],
            'question_id' => $input['question_id'],
        ]);

        flash('Resposta criada com sucesso!')->success();

        return redirect(route('answer.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $answer = Answer::find($id);

        if(empty($answer)) {
            flash('Resposta não encontrada!')->error();

            return redirect(route('answers.index'));
        }

        return view('pandoapps::answers.show', compact('answer'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $answer = Answer::find($id);

        if(empty($answer)) {
            flash('Resposta não encontrada!')->error();

            return redirect(route('answers.index'));
        }

        return view('pandoapps::answers.edit', compact('answer'));
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
        $answer = Answer::find($id);

        if(empty($answer)) {
            flash('Resposta não encontrada!')->error();

            return redirect(route('answers.index'));
        }

        $input = $request->all();

        $answerValidation = Validator::make($input, Answer::$rules);
        if ($answerValidation->fails()) {
            $errors = $answerValidation->errors();
            $msg = '';
            foreach($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect()->back()->withInput();
        }

        $answer->update($input);

        flash('Resposta atualizada com sucesso!')->success();

        return redirect(route('answers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $answer = Answer::find($id);

        if(empty($answer)) {
            flash('Resposta não encontrada!')->error();

            return redirect(route('answers.index'));
        }

        $id = $answer->id;
        $answer->delete();

        flash('Resposta deletada com sucesso!')->success();

        return redirect(route('answers.index', $id));
    }
}
