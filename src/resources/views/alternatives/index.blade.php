@extends('pandoapps::layouts.app')

@section('content_pandoapps')
    <section class="content-header">
        <h1 class="pull-left">Alternativas</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('pandoapps::flash-message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('pandoapps::alternatives.table')
            </div>
        </div>
    </div>
@endsection
