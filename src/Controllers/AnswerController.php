<?php

namespace PandoApps\Quiz\Controllers;

use Illuminate\Routing\Controller;
use PandoApps\Quiz\DataTables\AnswerDataTableInterface;
use PandoApps\Quiz\Models\Answer;
use PandoApps\Quiz\Helpers\Helpers;

class AnswerController extends Controller
{
    private $answerDataTableInterface;
    private $params;

    public function __construct(AnswerDataTableInterface $answerDataTableInterface)
    {
        $this->answerDataTableInterface = $answerDataTableInterface;
        $this->params = Helpers::getAllParameters();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->answerDataTableInterface->render('pandoapps::answers.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id = request()->answer_id;
        $answer = Answer::find($id);

        if (empty($answer)) {
            flash('Resposta não encontrada!')->error();
            return redirect(route('answers.index', $this->params));
        }

        return view('pandoapps::answers.show', compact('answer'));
    }
}
