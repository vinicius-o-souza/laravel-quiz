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
     * Display the specified resource.
     *
     * @param  int  $parentId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($parentId, $id)
    {
        $question = Question::find($id);

        if(empty($question)) {
            flash('Questão não encontrada!')->error();

            return redirect(route('questions.index', $parentId));
        }

        return view('pandoapps::questions.show', compact('question'));
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
        $question = Question::find($id);

        if(empty($question)) {
            flash('Questão não encontrada!')->error();

            return redirect(route('questions.index', $parentId));
        }

        $id = $question->id;
        $question->delete();

        if(request()->ajax()) {
            return response()->json(['status' => 'Questão deletada']);
        } 
        flash('Questão deletada com sucesso!')->success();

        return redirect(route('questions.index', $parentId));
    }
}
