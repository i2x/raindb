@extends('submenu')

{{-- Content --}}
@section('content')

@if($ampher_message != NULL){{$ampher_message}}
@endif


	
			

@if(isset($data['source_id']))
{{ Form::open(array('url' => URL::to('database/amphur/'.$data['source_id'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/amphur/create') )) }}
@endif

	
   <div class="form-group">
  {{ Form::label('source_id')}}
  @if(isset($data['source_id']))
  
  {{ Form::text('source_id', $data['source_id'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('source_id','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('source_id')}}</p>
   
  </div>
  
  
  <div class="form-group">
  {{ Form::label('source_name')}}
  @if(isset($data['source_name']))
  {{
  	 Form::text('source_name', $data['source_name'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @else
  {{ 
  
  	Form::text('source_name', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('source_name')}}</p>
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



