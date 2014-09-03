@extends('submenu')

{{-- Content --}}
@section('content')

@if($ampher_message != NULL){{$ampher_message}}
@endif

	

@if(isset($data['id']))
{{ Form::open(array('url' => URL::to('database/tbl_ref_data4forecast_ping/'.$data['id'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/tbl_ref_data4forecast_ping/create') )) }}
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
  
  {{ Form::text('season', $data['season'],array( 'class' => 'form-control', 'placeholder' => 'Enter season'  )) }}
 
  @else
 
  {{ Form::text('season','',array( 'class' => 'form-control', 'placeholder' => 'Enter season'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('season')}}</p>
   
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
  {{ Form::label('meas_value1')}}
  @if(isset($data['meas_value1']))
  {{
  	 Form::text('meas_value1', $data['meas_value1'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('meas_value1', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('meas_value1')}}</p>
  
  
  </div>
  
  
     <div class="form-group">
  {{ Form::label('meas_value2')}}
  @if(isset($data['meas_value2']))
  
  {{ Form::text('meas_value2', $data['meas_value2'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('meas_value2','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('meas_value2')}}</p>
   
  </div>
  
  
  
     <div class="form-group">
  {{ Form::label('meas_value3')}}
  @if(isset($data['meas_value3']))
  
  {{ Form::text('meas_value3', $data['meas_value3'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('meas_value3','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('meas_value3')}}</p>
  
  
  
     <div class="form-group">
  {{ Form::label('meas_value4')}}
  @if(isset($data['meas_value4']))
  
  {{ Form::text('meas_value4', $data['meas_value4'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('meas_value4','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('meas_value4')}}</p>
  
  
  
     <div class="form-group">
  {{ Form::label('meas_value5')}}
  @if(isset($data['meas_value5']))
  
  {{ Form::text('meas_value5', $data['meas_value5'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('meas_value5','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('meas_value5')}}</p>
  
  
  

  
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



