@extends('submenu')

{{-- Content --}}
@section('content')

@if($ampher_message != NULL){{$ampher_message}}
@endif


				

@if(isset($data['id']))
{{ Form::open(array('url' => URL::to('database/tbl_season/'.$data['id'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/tbl_season/create') )) }}
@endif

	
   <div class="form-group">
  {{ Form::label('id')}}
  @if(isset($data['id']))
  
  {{ Form::text('id', $data['id'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('id','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('id')}}</p>
   
  </div>
  
  
  <div class="form-group">
  {{ Form::label('season')}}
  @if(isset($data['season']))
  {{
  	 Form::text('season', $data['season'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @else
  {{ 
  
  	Form::text('season', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('season')}}</p>
    </div>

  

  
  

  
  	<div class="form-group">
		
				<!--  <element class="btn btn-default close_popup">Cancel</element>-->
				
				<button type="submit" class="btn btn-success">
				{{($mode == 'Create') ? 'Create' : 'Update'}}
				</button>
				
				<button type="reset" class="btn btn-default">
				
				<span class="glyphicon glyphicon-repeat"></span> Reset
				
				</button>
		</div>
 


{{ Form::close() }}
@stop



