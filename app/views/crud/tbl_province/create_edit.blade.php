@extends('submenu')




{{-- Content --}}
@section('content')

@if($ampher_message != NULL){{$ampher_message}}
@endif


				

@if(isset($data['province_id']))
{{ Form::open(array('url' => URL::to('database/amphur/'.$data['province_id'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/amphur/create') )) }}
@endif

	
   <div class="form-group">
  {{ Form::label('province_id')}}
  @if(isset($data['province_id']))
  
  {{ Form::text('province_id', $data['province_id'],array( 'class' => 'form-control', 'placeholder' => 'Enter province_id'  )) }}
 
  @else
 
  {{ Form::text('province_id','',array( 'class' => 'form-control', 'placeholder' => 'Enter province_id'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('province_id')}}</p>
   
  </div>
  
  
  <div class="form-group">
  {{ Form::label('province_name')}}
  @if(isset($data['province_name']))
  {{
  	 Form::text('province_name', $data['province_name'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @else
  {{ 
  
  	Form::text('province_name', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('province_name')}}</p>
    </div>

  
  
  
  
     <div class="form-group">
  {{ Form::label('region_id')}}
  @if(isset($data['region_id']))
  {{
  	 Form::text('region_id', $data['region_id'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('region_id', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('region_id')}}</p>
    
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



