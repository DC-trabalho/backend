@extends('teste::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('teste.name') !!}</p>
@endsection