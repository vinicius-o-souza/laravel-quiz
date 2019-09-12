<?php

namespace PandoApps\Quiz\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use PandoApps\Quiz\DataTables\AlternativeDataTable;
use PandoApps\Quiz\Models\Alternative;

class AlternativeController extends Controller
{
    private $parentName;

    public function __construct()
    {
        $this->parentName = config('quiz.models.parent_id');
    }

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
     * Display the specified resource.
     *
     * @param  int  $parentId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($parentId, $id)
    {
        $alternative = Alternative::find($id);

        if (empty($alternative)) {
            flash('Alternativa não encontrada!')->error();

            return redirect(route('alternatives.index', $parentId));
        }

        return view('pandoapps::alternatives.show', compact('alternative'));
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
        $alternative = Alternative::find($id);

        if (empty($alternative)) {
            flash('Alternativa não encontrada!')->error();

            return redirect(route('alternatives.index', $parentId));
        }

        return view('pandoapps::alternatives.edit', compact('alternative'));
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
        $alternative = Alternative::find($id);

        if (empty($alternative)) {
            flash('Alternativa não encontrada!')->error();

            return redirect(route('alternatives.index', $parentId));
        }
        
        $question = $alternative->question;
        if ($question->alternatives()->count() == 1) {
            flash('Questões fechadas devem ter no mínimo 1 alternativa!')->error();

            return redirect(route('alternatives.index', $parentId));
        }

        $alternative->delete();
        
        if (request()->ajax()) {
            return response()->json(['status' => 'Alternativa deletada']);
        }

        flash('Alternativa deletada com sucesso!')->success();

        return redirect(route('alternatives.index', $parentId));
    }
}
