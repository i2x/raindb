@extends('submenu')

{{-- Content --}}
@section('content')





@if($ampher_message != NULL){{$ampher_message}}
@endif


				

@if(isset($data['basin_id']))
{{ Form::open(array('url' => URL::to('database/riverbasin/'.$data['basin_id'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/riverbasin/create') )) }}
@endif

	
   <div class="form-group">
  {{ Form::label('basin_id')}}
  @if(isset($data['basin_id']))
  
  {{ Form::text('basin_id', $data['basin_id'],array( 'class' => 'form-control', 'placeholder' => 'Enter basin_id'  )) }}
 
  @else
 
  {{ Form::text('basin_id','',array( 'class' => 'form-control', 'placeholder' => 'Enter basin_id'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('basin_id')}}</p>
   
  </div>
  
  
  <div class="form-group">
  {{ Form::label('basin_name')}}
  @if(isset($data['basin_name']))
  {{
  	 Form::text('basin_name', $data['basin_name'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter basin_name'  ))
  }}
  @else
  {{ 
  
  	Form::text('basin_name', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter basin_name'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('basin_name')}}</p>
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



