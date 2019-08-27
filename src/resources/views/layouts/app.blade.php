@extends('layouts.app')

@section('css')
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/pandoapps_quiz/css/all.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">

    <!-- Select 2 style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

    @stack('css_quiz')

@endsection

@section('content')
    @yield('content_pandoapps')
@endsection

@section('scripts')
    @stack('scripts_quiz')
@endsection
