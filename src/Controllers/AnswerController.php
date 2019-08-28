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

            return redirect(route('answers.index', request()->parent_id));
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

            return redirect(route('answers.index', request()->parent_id));
        }

        return view('pandoapps::answers.edit', compact('answer'));
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

            return redirect(route('answers.index', request()->parent_id));
        }

        $id = $answer->id;
        $answer->delete();

        flash('Resposta deletada com sucesso!')->success();

        return redirect(route('answers.index', request()->parent_id));
    }
}
