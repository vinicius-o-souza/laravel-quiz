@extends('pandoapps::layouts.app')

@section('content_pandoapps')
    <section class="content-header">
        <h1 class="pull-left"> Alternativas</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('alternatives.index', request()->$parentName) !!}">Voltar</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('pandoapps::flash-message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::model($alternative, ['route' => ['alternatives.update', request()->$parentName, $alternative->id], 'method' => 'patch', 'class' => 'w-100']) !!}

                        @include('pandoapps::alternatives.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
