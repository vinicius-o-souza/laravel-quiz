@extends('pandoapps::layouts.app')

@section('content_pandoapps')
    <section class="content-header">
        <h1 class="pull-left"> {{ $questionnaire->name }} </h1>
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
                <div id="start_block" class="container text-center" style="padding: 100px 50px">
                    <button type="button" id="start_button" class="btn btn-success btn-lg" style="padding: 20px 40px">INICIAR <i class="fa fa-play"></i></button>
                </div>
                <div id="questionnaire_form_block">
                    <p id="timer" style="text-align: center; font-size: 60px; margin-top: 0px;"></p>
                    {!! Form::open(['route' => ['executables.store', request()->$parentId, $questionnaire->id], 'class' => 'w-100', 'id' => 'questionnaire_form']) !!}
                        <input id="model_id" type="hidden" name="model_id" value="{{ Auth::user()->id }}">
                        <div class="row p-md-5">
                            @foreach($questionnaire->questions as $key => $question)
                                <div class="form-group col-sm-12 col-md-6">
                                    <h4> <span class="font-weight-bold">{!! $key + 1 !!}.</span> {!! $question->description !!} {!! $question->is_required ? '<span class="text-danger"> * </span>' : '' !!}</h4>
                                    @if($question->isClosed())
                                        <div class="form-group">
                                            @foreach($question->alternatives as $alternative)
                                                <div class="radio">
                                                    <label><input type="radio" name="{!! $question->id !!}" {!! $question->is_required ? 'required' : '' !!} value="{!! $alternative->id !!}"> {!! $alternative->description !!}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <textarea class="form-control" name="{!! $question->id !!}" id="{!! $question->id !!}" rows="2" {!! $question->is_required ? 'required' : '' !!}></textarea>
                                    @endif
                                </div>
                            @endforeach    
                            <!-- Submit Field -->
                            <div class="form-group col-sm-12 pt-5">
                                {!! Form::submit('Responder', ['class' => 'btn btn-primary']) !!}
                                <a href="{!! route('executables.index', [$parentId => request()->$parentId, 'questionnaire_id' => $questionnaire->id]) !!}" class="btn btn-default">Cancelar</a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>            
            </div>
        </div>
    </div>
@endsection

@push('scripts_quiz')
    <script src="{{ asset('vendor/pandoapps/js/jquery.min.js') }}" type="text/javascript"></script> 
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('#questionnaire_form_block').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
    
        $(document).on("click", "#start_button", function() {
            var modelId = $('#model_id').val();
            var questionnaireId = '{!! request()->questionnaire_id !!}';
            $.ajax({
                url:'{!! route("executables.start", request()->$parentId) !!}',
                type: 'POST',
                data:{
                    "_token": "{{ csrf_token() }}",
                    questionnaire_id: questionnaireId,
                    model_id: modelId
                },
                success:function(data){
                    if(data.status == 'error') {
                        swal({
                            title: "Atenção!", 
                            text: data.msg, 
                            icon: "warning",
                            dangerMode: true,
                        });
                    } else {
                        $('#start_block').hide();
                        $('#questionnaire_form_block').show();
                        if(data.status == 'success') {
                            if(data.executionTime) {
                                timer(data.executionTime);    
                            }
                        }   
                    }
                },
                error: function(data) {
                    swal({
                        title: "Erro!", 
                        text: "Ocorre um erro ao iniciar a prova, tente novamente mais tarde!", 
                        icon: "error",
                        dangerMode: true,
                    });
                }
            });
        });            
        
        function timer(time) {
            // Set the date we're counting down to
            var countDownDate = new Date(time).getTime();
            
            // Update the count down every 1 second
            var myTimer = setInterval(countDown, 1000);
            function countDown() {
        
                // Get today's date and time
                var now = new Date().getTime();
                    
                // Find the distance between now and the count down date
                var distance = countDownDate - now;
                    
                // Time calculations for days, hours, minutes and seconds
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    
                // Output the result in an element with id="timer"
                document.getElementById("timer").innerHTML = hours + "h "
                    + minutes + "m " + seconds + "s ";
                    
                // If the count down is over, write some text 
                if (distance < 0) {
                    $('#questionnaire_form').submit();
                    clearInterval(myTimer);
                }
            }
        }   
    </script>
@endpush
