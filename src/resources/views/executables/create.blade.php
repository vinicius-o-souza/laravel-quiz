@extends('pandoapps::layouts.app')

@section('content_pandoapps')
    <section class="content-header">
        <h1 class="pull-left"> {{ $questionnaire->name }} </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('pandoapps::flash-message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                {!! Form::open(['route' => ['executables.store', $questionnaire->id, Auth::user()->id], 'class' => 'w-100']) !!}
                    <div class="row p-md-5">
                        @foreach($questionnaire->questions as $key => $question)
                            <div class="form-group col-sm-12 col-md-6">
                                <h4> <span class="font-weight-bold">{!! $key + 1 !!}.</span> {!! $question->description !!} {!! $question->is_required ? '<span class="text-danger"> * </span>' : '' !!}</h4>
                                @if($question->question_type_id == config('quiz.question_types.OPEN.id'))
                                    <textarea class="form-control" name="{!! $question->id !!}" id="{!! $question->id !!}" rows="2" {!! $question->is_required ? 'required' : '' !!}></textarea>
                                @else
                                    <div class="form-group">
                                        @foreach($question->alternatives as $alternative)
                                            <div class="radio">
                                                <label><input type="radio" name="{!! $question->id !!}" {!! $question->is_required ? 'required' : '' !!} value="{!! $alternative->id !!}"> {!! $alternative->description !!}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach    
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12 pt-5">
                            {!! Form::submit('Responder', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('executables.index', ['questionnaire_id' => $questionnaire->id, 'model_id' => Auth::user()->id]) !!}" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts_quiz')
    <script src="{{ asset('vendor/pandoapps_quiz/js/jquery.min.js') }}"></script> 
    <script>
        $('input[required]').on('invalid', function() {
            this.setCustomValidity('Campo de preenchimento obrigatório.');
        });
        $('textarea[required]').on('invalid', function() {
            this.setCustomValidity('Campo de preenchimento obrigatório.');
        });
    </script>
@endpush
