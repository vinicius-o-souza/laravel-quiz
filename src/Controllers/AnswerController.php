<?php

namespace PandoApps\Quiz\Controllers;

use Illuminate\Routing\Controller;
use PandoApps\Quiz\DataTables\AnswerDataTable;
use PandoApps\Quiz\Models\Answer;

class AnswerController extends Controller
{
    private $parentName;

    public function __construct()
    {
        $this->parentName = config('quiz.models.parent_id');
    }

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
     * @param  int  $parentId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($parentId, $id)
    {
        $answer = Answer::find($id);

        if (empty($answer)) {
            flash('Resposta não encontrada!')->error();

            return redirect(route('answers.index', $parentId));
        }

        return view('pandoapps::answers.show', compact('answer'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $parentId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($parentId, $id)
    {
        $answer = Answer::find($id);

        if (empty($answer)) {
            flash('Resposta não encontrada!')->error();

            return redirect(route('answers.index', $parentId));
        }

        return view('pandoapps::answers.edit', compact('answer'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $parentId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($parentId, $id)
    {
        $answer = Answer::find($id);

        if (empty($answer)) {
            flash('Resposta não encontrada!')->error();

            return redirect(route('answers.index', $parentId));
        }

        $answer->delete();

        flash('Resposta deletada com sucesso!')->success();

        return redirect(route('answers.index', $parentId));
    }
}
