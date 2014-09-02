@extends('submenu')

{{-- Content --}}
@section('content')



@if($ampher_message != NULL){{$ampher_message}}
@endif


				

@if(isset($data['ampher_id']))
{{ Form::open(array('url' => URL::to('database/amphur/'.$data['ampher_id'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/amphur/create') )) }}
@endif

	
   <div class="form-group">
  {{ Form::label('ampher_id')}}
  @if(isset($data['ampher_id']))
  
  {{ Form::text('ampher_id', $data['ampher_id'],array( 'class' => 'form-control', 'placeholder' => 'Enter ampher_id'  )) }}
 
  @else
 
  {{ Form::text('ampher_id','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('ampher_id')}}</p>
   
  </div>
  
  
  <div class="form-group">
  {{ Form::label('name')}}
  @if(isset($data['name']))
  {{
  	 Form::text('name', $data['name'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter name'  ))
  }}
  @else
  {{ 
  
  	Form::text('name', '',
 	array( 'class' => 'form-control', 'placeholder' => 'name Name'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('name')}}</p>
    </div>

  
  
  
  
     <div class="form-group">
  {{ Form::label('province_id')}}
  @if(isset($data['province_id']))
  {{
  	 Form::text('province_id', $data['province_id'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter province_id'  ))
  }}
  @else
  {{ 
  
  	Form::text('province_id', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('province_id')}}</p>
    
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



