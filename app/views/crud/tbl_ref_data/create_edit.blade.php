@extends('submenu')

{{-- Content --}}
@section('content')

@if($ampher_message != NULL){{$ampher_message}}
@endif


				

@if(isset($data['id']))
{{ Form::open(array('url' => URL::to('database/amphur/'.$data['id'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/amphur/create') )) }}
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
  {{ Form::label('meas_year')}}
  @if(isset($data['meas_year']))
  {{
  	 Form::text('meas_year', $data['meas_year'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @else
  {{ 
  
  	Form::text('meas_year', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('meas_year')}}</p>
    </div>

  
  
  
  
     <div class="form-group">
  {{ Form::label('meas_month')}}
  @if(isset($data['meas_month']))
  {{
  	 Form::text('meas_month', $data['meas_month'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('meas_month', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('meas_month')}}</p>
    
  </div>
  
  
  
  
     <div class="form-group">
  {{ Form::label('meas_value')}}
  @if(isset($data['meas_value']))
  {{
  	 Form::text('meas_value', $data['meas_value'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('meas_value', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('meas_value')}}</p>
  
  
  </div>
  
  
  
         <div class="form-group">
  {{ Form::label('refid')}}
  @if(isset($data['refid']))
  {{
  	 Form::text('refid', $data['refid'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('refid', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('refid')}}</p>
  
  
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



