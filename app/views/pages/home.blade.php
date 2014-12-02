@extends('master')

@section('title', 'Home')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="jumbotron">
            
            
            
                <h1> </h1>
                <p class="lead">
                
                Welcome to seasonal forecast system. Please  <a href="{{URL::to('login')}}">login</a> or 
                <a href="{{URL::to('register')}}"> sign up.</a> 
                <img src="{{asset('assets/images/frontend.png')}}">
                </p>
                
                
               
                
            </div>
        </div>
    </div>

  

@stop

