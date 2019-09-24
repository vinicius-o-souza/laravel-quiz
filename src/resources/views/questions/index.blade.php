@extends('pandoapps::layouts.app')

@section('content_pandoapps')
    <section class="content-header">
        <h1 class="pull-left">Questões</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('questionnaires.index', request()->$parentId) !!}">Voltar</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('pandoapps::flash-message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('pandoapps::questions.table')
            </div>
        </div>
    </div>
@endsection

