@push('css_quiz')
    @include('pandoapps::layouts.datatables_css')
@endpush

{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}

@push('scripts_quiz')
    @include('pandoapps::layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush
