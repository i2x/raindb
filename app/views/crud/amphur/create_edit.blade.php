@extends('submenu')

{{-- Content --}}
@section('content')

@if($ampher_message != NULL){{$ampher_message}}
@endif

				

@if(isset($data['AMPHUR_ID']))
{{ Form::open(array('url' => URL::to('database/amphur/'.$data['AMPHUR_ID'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/amphur/'."create".'/post') )) }}
@endif

	



  
   <div class="form-group">
  {{ Form::label('AMPHUR_CODE')}}
  @if(isset($data['AMPHUR_CODE']))
  {{
  	 Form::text('AMPHUR_CODE', $data['AMPHUR_CODE'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  ))
  }}
  @else
  {{ 
  
  	Form::text('AMPHUR_CODE', ' ',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  ))
  }}
  @endif</div>
  
  
     <div class="form-group">
  {{ Form::label('AMPHUR_NAME')}}
  @if(isset($data['AMPHUR_NAME']))
  {{
  	 Form::text('AMPHUR_NAME', $data['AMPHUR_NAME'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  ))
  }}
  @else
  {{ 
  
  	Form::text('AMPHUR_NAME', ' ',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  ))
  }}
  @endif</div>
  
  
  
     <div class="form-group">
  {{ Form::label('GEO_ID')}}
  @if(isset($data['GEO_ID']))
  {{
  	 Form::text('GEO_ID', $data['GEO_ID'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  ))
  }}
  @else
  {{ 
  
  	Form::text('GEO_ID', ' ',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  ))
  }}
  @endif</div>
  
  
  
     <div class="form-group">
  {{ Form::label('PROVINCE_ID')}}
  @if(isset($data['PROVINCE_ID']))
  {{
  	 Form::text('PROVINCE_ID', $data['PROVINCE_ID'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  ))
  }}
  @else
  {{ 
  
  	Form::text('PROVINCE_ID', ' ',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  ))
  }}
  @endif</div>
  
  
  

  
  	<div class="form-group">
		
				<!--  <element class="btn btn-default close_popup">Cancel</element>-->
				<button type="submit" class="btn btn-success">Update</button>
				
				<button type="reset" class="btn btn-default">
				
				<span class="glyphicon glyphicon-repeat"></span> Reset
				
				</button>
		</div>
 


{{ Form::close() }}
@stop



