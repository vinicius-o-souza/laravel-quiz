@extends('pandoapps::layouts.app')

@section('content_pandoapps')
    <section class="content-header">
        <h1 class="pull-left">Execuções</h1>
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
            <div class="box-body container">
                <h1> {{ $executablesIndividual->total() }} respostas</h1>
                @if(!$executablesIndividual->isEmpty())
                <div>
                    <div class="btn-group">
                        <a id="summaryBtn" class="btnOptions btn btn-lg btn-defaut" data-option="summary"> Todas respostas </a>
                        <a id="individualBtn" class="btnOptions btn btn-lg btn-primary active" data-option="individual"> Individual </a>
                    </div>
                    <hr>
                    <div class="options" id="summary">
                        @foreach($questionnaire->questions as $question)
                            <div style="padding: 5% 5%">
                                <div>
                                    <h3>{{ $question->description }}</h3>
                                    <h5>{{ $executablesSummary[$question->id]['count'] }} respostas</h5>
                                </div>
                                @if($question->isClosed())
                                    <div id="container-{!! $executablesSummary[$question->id]['chart']['chart_id'] !!}"></div>
                                    @push('scripts_charts')
                                        <script>
                                            {!! $executablesSummary[$question->id]['chart']['chart_data'] !!}
                                        </script>
                                    @endpush
                                @else
                                    <table class="table table-striped">
                                        <tbody>
                                            @foreach ($executablesSummary[$question->id]['answers'] as $answers)
                                                <tr><td>{!! $answers->description !!}</td></tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="options" id="individual" style="display:none">
                        <div>
                            <div class="paginate text-right">
                                {{ $executablesIndividual->links() }}
                            </div>
                            <div style="padding: 0% 5%">
                                @foreach ($executablesIndividual as $executable)
                                    @php $executableName = config('quiz.models.executable_column_name'); @endphp
                                    <div>
                                        <h3>{{ $executable->executable->$executableName }}</h3>
                                        <h5>Nota: {{ $executable->score }}</h5>
                                    </div>
                                    <div>
                                        @foreach($executable->answers as $key => $answer)
                                            <div class="form-group col-sm-12 col-md-6">
                                                <h4> <span class="font-weight-bold">{!! $key + 1 !!}.</span> {!! $answer->question->description !!}</h4>
                                                <h5> Nota: {{ $answer->score }}</h5>
                                                @if($answer->question->question_type_id == config('quiz.question_types.OPEN.id'))
                                                    <textarea class="form-control" name="{!! $answer->question->id !!}" id="{!! $answer->question->id !!}" {!! $answer->question->is_required ? 'required' : '' !!} disabled> {!! $answer->description !!}</textarea>
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
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection     

@push('css_quiz')
    <style>
        .highcharts-button {
            display: none;
        }
        .highcharts-credits {
            display: none;
        }
    </style>
@endpush

@push('scripts_quiz')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
    <script>
        $(document).ready(function() {
            Highcharts.setOptions({lang: {decimalPoint: ",", thousandsSep: '.', noData: "Nenhum dado disponível."}});
            onClick();
            var paramPage = location.search.split('page=')[1];
            if(paramPage) {
                $('#individual').show();
                $('#summary').hide();
            } else {
                $('#individualBtn').removeClass('active');
                $('#individualBtn').removeClass('btn-primary');
                $('#individualBtn').addClass('btn-default');
                $('#summaryBtn').addClass('active');
                $('#summaryBtn').addClass('btn-primary');
            }
        });
        
        function onClick() {
            $(document).on('click', '.btnOptions', function () {
                $('.btnOptions').removeClass('active');
                $('.btnOptions').removeClass('btn-primary');
                $('.btnOptions').addClass('btn-default');
                $(this).addClass('active');
                $(this).addClass('btn-primary');
                
                $('.options').hide();
                var option = $(this).data('option');
                $('#' + option).show();
            });
        }
    </script>
    @stack('scripts_charts')
@endpush