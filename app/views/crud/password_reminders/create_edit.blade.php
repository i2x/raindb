@extends('submenu')

{{-- Content --}}
@section('content')

@if($ampher_message != NULL){{$ampher_message}}
@endif

				

@if(isset($data['AMPHUR_ID']))
{{ Form::open(array('url' => URL::to('database/amphur/'.$data['AMPHUR_ID'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/amphur/create') )) }}
@endif

	
   <div class="form-group">
  {{ Form::label('id')}}
  @if(isset($data['id']))
  
  {{ Form::text('id', $data['id'],array( 'class' => 'form-control', 'placeholder' => 'Enter id'  )) }}
 
  @else
 
  {{ Form::text('id','',array( 'class' => 'form-control', 'placeholder' => 'Enter id'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('id')}}</p>
   
  </div>
  
  
  <div class="form-group">
  {{ Form::label('email')}}
  @if(isset($data['email']))
  {{
  	 Form::text('email', $data['email'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter email'  ))
  }}
  @else
  {{ 
  
  	Form::text('email', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter email'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('email')}}</p>
    </div>

  
  
  
  
     <div class="form-group">
  {{ Form::label('token')}}
  @if(isset($data['token']))
  {{
  	 Form::text('token', $data['token'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter token'  ))
  }}
  @else
  {{ 
  
  	Form::text('token', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter token'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('token')}}</p>
    
  </div>
  
  
  
  
     <div class="form-group">
  {{ Form::label('created_at')}}
  @if(isset($data['created_at']))
  {{
  	 Form::text('created_at', $data['created_at'],
 	 array( 'class' => 'form-control', 'created_at' => 'Enter created_at'  ))
  }}
  @else
  {{ 
  
  	Form::text('created_at', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter created_at'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('created_at')}}</p>
  
  
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



