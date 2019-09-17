<?php

namespace PandoApps\Quiz\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use PandoApps\Quiz\DataTables\AlternativeDataTableInterface;
use PandoApps\Quiz\Models\Alternative;

class AlternativeController extends Controller
{
    private $alternativeDataTableInterface;
    private $params;

    public function __construct(AlternativeDataTableInterface $alternativeDataTableInterface)
    {
        $this->alternativeDataTableInterface = $alternativeDataTableInterface;
        $this->params = \Route::getCurrentRoute()->parameters();
        unset($this->params['alternative_id']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->alternativeDataTableInterface->render('pandoapps::alternatives.index');
    }
    
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id = request()->alternative_id;
        $alternative = Alternative::find($id);

        if (empty($alternative)) {
            flash('Alternativa não encontrada!')->error();
            return redirect(route('alternatives.index', $this->params));
        }

        return view('pandoapps::alternatives.show', compact('alternative'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = request()->alternative_id;
        $alternative = Alternative::find($id);

        if (empty($alternative)) {
            flash('Alternativa não encontrado!')->error();
            return redirect(route('alternatives.index', $this->params));
        }

        return view('pandoapps::alternatives.edit', compact('alternative'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = request()->alternative_id;
        $alternative = Alternative::find($id);

        if (empty($alternative)) {
            flash('Alternativa não encontrado!')->error();
            return redirect(route('alternatives.index', $this->params));
        }

        $input = $request->all();
        if(isset($input['is_correct'])) {
            $input['is_correct'] = true;
        } else {
            $input['is_correct'] = false;
        }

        $alternativeValidation = Validator::make($input, Alternative::$rules);
        if ($alternativeValidation->fails()) {
            $errors = $alternativeValidation->errors();
            $msg = '';
            foreach ($errors->all() as $message) {
                $msg .= $message . '<br>';
            }
            flash($msg)->error();
            return redirect(route('alternatives.index', $this->params));
        }

        $alternative->update($input);
        flash('Alternativa atualizada com sucesso!')->success();
        return redirect(route('alternatives.index', $this->params));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id = request()->alternative_id;
        $alternative = Alternative::find($id);

        if (empty($alternative)) {
            flash('Alternativa não encontrada!')->error();
            return redirect(route('alternatives.index', $this->params));
        }
        
        $question = $alternative->question;
        if ($question->alternatives()->count() == 1) {
            flash('Questões fechadas devem ter no mínimo 1 alternativa!')->error();
            return redirect(route('alternatives.index', $this->params));
        }

        $alternative->delete();
        
        if (request()->ajax()) {
            return response()->json(['status' => 'Alternativa deletada']);
        }

        flash('Alternativa deletada com sucesso!')->success();

        return redirect(route('alternatives.index', $parentId));
    }
}
