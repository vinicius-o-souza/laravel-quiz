@extends('pandoapps::layouts.app')

@section('content_pandoapps')
    <section class="content-header">
        <h1 class="pull-left"> {{ $executable->questionnaire->name }} </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('pandoapps::flash-message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row p-md-5">
                    @if($executable->answers->isEmpty())
                        <div class="col-sm-12">
                            <div class="alert alert-danger">Você não respondeu a nenhuma questão e o tempo foi esgotado!</div>
                        </div>
                    @else
                        @foreach($executable->answers as $key => $answer)
                            <div class="form-group col-sm-12 col-md-6">
                                <h4> <span class="font-weight-bold">{!! $key + 1 !!}.</span> {!! $answer->question->description !!} {!! $answer->question->is_required ? '<span class="text-danger"> * </span>' : '' !!}</h4>
                                @if($answer->question->question_type_id == config('quiz.question_types.OPEN.id'))
                                    <textarea class="form-control" name="{!! $answer->question->id !!}" id="{!! $answer->question->id !!}" rows="2" {!! $answer->question->is_required ? 'required' : '' !!} disabled> {!! $answer->description !!}</textarea>
                                @else
                                    <div class="form-group">
                                        @foreach($answer->question->alternatives as $alternative)
                                            <div class="radio">
                                                @if ($answer->alternative_id == $alternative->id)
                                                    <label class="{{ $answer->score ? 'text-success' : 'text-danger' }}">
                                                        <input type="radio" name="{!! $answer->question->id !!}" {!! $answer->question->is_required ? 'required' : '' !!} value="{!! $alternative->id !!}" disabled checked>
                                                        {!! $alternative->description !!}
                                                    </label>
                                                @else
                                                    <label><input type="radio" name="{!! $answer->question->id !!}" {!! $answer->question->is_required ? 'required' : '' !!} value="{!! $alternative->id !!}" disabled
                                                        @if ($answer->alternative_id == $alternative->id)
                                                            {!! 'checked' !!}
                                                        @endif
                                                        >{!! $alternative->description !!}
                                                    </label>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach    
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection