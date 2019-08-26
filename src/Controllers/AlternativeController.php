<?php

namespace PandoApps\Quiz\Controllers;

use PandoApps\Quiz\Models\Alternative;
use PandoApps\Quiz\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use PandoApps\Quiz\DataTables\AlternativeDataTable;

class AlternativeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param AlternativeDataTable $alternativeDataTable
     * @return \Illuminate\Http\Response
     */
    public function index(AlternativeDataTable $alternativeDataTable)
    {
        return $alternativeDataTable->render('pandoapps::alternatives.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $questions = Question::where('questionnaire_id', request()->questionnaire_id)->orderBy('title','asc')->pluck('title','id')->toArray();

        return view('pandoapps::alternatives.create', compact('questions'));
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

        $alternativeValidation = Validator::make($input, Alternative::$rules);
        if ($alternativeValidation->fails()) {
            $errors = $alternativeValidation->errors();
            $msg = '';
            foreach($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect()->back()->withInput();
        }

        Alternative::create([
            'description' => $input['description'],
            'question_id' => $input['question_id'],
        ]);

        flash('Alternativa criada com sucesso!')->success();
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alternative = Alternative::find($id);

        if(empty($alternative)) {
            flash('Alternativa não encontrada!')->error();

            return redirect(route('alternatives.index'));
        }

        return view('pandoapps::alternatives.show', compact('alternative'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alternative = Alternative::find($id);

        if(empty($alternative)) {
            flash('Alternativa não encontrada!')->error();

            return redirect(route('alternatives.index'));
        }

        return view('pandoapps::alternatives.edit', compact('alternative'));
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
        $alternative = Alternative::find($id);

        if(empty($alternative)) {
            flash('Alternativa não encontrada!')->error();

            return redirect(route('alternatives.index'));
        }

        $input = $request->all();

        $alternativeValidation = Validator::make($input, Alternative::$rules);
        if ($alternativeValidation->fails()) {
            $errors = $alternativeValidation->errors();
            $msg = '';
            foreach($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect()->back()->withInput();
        }

        $alternative->update($input);

        if(request()->ajax()) {
            return response()->json(['status' => 'Questão deletada']);
        }
        
        flash('Alternativa atualizada com sucesso!')->success();

        return redirect(route('alternatives.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alternative = Alternative::find($id);

        if(empty($alternative)) {
            flash('Alternativa não encontrada!')->error();

            return redirect(route('alternatives.index'));
        }
        
        $question = $alternative->question;
        if($question->alternatives()->count() == 1) {
            flash('Questões fechadas devem ter no mínimo 1 alternativa!')->error();

            return redirect(route('alternatives.index'));
        }

        $id = $alternative->id;
        $alternative->delete();
        
        if(request()->ajax()) {
            return response()->json(['status' => 'Alternativa deletada']);
        }

        flash('Alternativa deletada com sucesso!')->success();

        return redirect(route('alternatives.index', $id));
    }
}
