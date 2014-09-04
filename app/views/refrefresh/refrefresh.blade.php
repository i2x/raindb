@extends('protected.admin.master')
@section('title', 'refresh references ')


@section('content')

@if(isset($message))
    {{$message}} <br/>
@endif
{{ Form::open(array('url' => 'refrefresh' ,'method' => 'POST')) }}

<button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Update References</button>



{{ Form::close() }}

@stop