<?php

namespace PandoApps\Quiz\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use PandoApps\Quiz\DataTables\QuestionDataTableInterface;
use PandoApps\Quiz\Models\Question;

class QuestionController extends Controller
{
    private $questionDataTableInterface;
    private $params;

    public function __construct(QuestionDataTableInterface $questionDataTableInterface)
    {
        $this->questionDataTableInterface = $questionDataTableInterface;
        $this->params = \Route::getCurrentRoute()->parameters();
        unset($this->params['question_id']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->questionDataTableInterface->render('pandoapps::questions.index');
    }
    
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id = request()->question_id;
        $question = Question::find($id);

        if (empty($question)) {
            flash('Questão não encontrada!')->error();
            return redirect(route('questions.index', $this->params));
        }

        return view('pandoapps::questions.show', compact('question'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = request()->question_id;
        $question = Question::find($id);

        if (empty($question)) {
            flash('Questão não encontrado!')->error();
            return redirect(route('questions.index', $this->params));
        }

        return view('pandoapps::questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = request()->question_id;
        $question = Question::find($id);

        if (empty($question)) {
            flash('Questão não encontrado!')->error();
            return redirect(route('questions.index', $this->params));
        }

        $input = $request->all();
        $input['question_type_id'] = $question->question_type_id;

        $questionValidation = Validator::make($input, Question::$rules);
        if ($questionValidation->fails()) {
            $errors = $questionValidation->errors();
            $msg = '';
            foreach ($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect()->back()->withInput();
        }

        $question->update($input);
        flash('Questão atualizado com sucesso!')->success();
        return redirect(route('questions.index', $this->params));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = request()->question_id;
        $question = Question::find($id);

        if (empty($question)) {
            flash('Questão não encontrada!')->error();
            return redirect(route('questions.index', $this->params));
        }

        $question->delete();

        if (request()->ajax()) {
            return response()->json(['status' => 'Questão deletada']);
        }
        flash('Questão deletada com sucesso!')->success();
        return redirect(route('questions.index', $this->params));
    }
}
