@extends('submenu')

{{-- Content --}}
@section('content')



@if($ampher_message != NULL){{$ampher_message}}
@endif


				

@if(isset($data['meas_id']))
{{ Form::open(array('url' => URL::to('database/tbl_rain_measurement/'.$data['meas_id'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/tbl_rain_measurement/create') )) }}
@endif

	
   <div class="form-group">
  {{ Form::label('meas_id')}}
  @if(isset($data['meas_id']))
  
  {{ Form::text('meas_id', $data['meas_id'],array( 'class' => 'form-control', 'placeholder' => 'Enter meas_id'  )) }}
 
  @else
 
  {{ Form::text('meas_id','',array( 'class' => 'form-control', 'placeholder' => 'Enter meas_id'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('meas_id')}}</p>
   
  </div>
  
  
  <div class="form-group">
  {{ Form::label('meas_date')}}
  @if(isset($data['meas_date']))
  {{
  	 Form::text('meas_date', $data['meas_date'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @else
  {{ 
  
  	Form::text('meas_date', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('meas_date')}}</p>
    </div>

  
  
  
  
     <div class="form-group">
  {{ Form::label('station_id')}}
  @if(isset($data['station_id']))
  {{
  	 Form::text('station_id', $data['station_id'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('station_id', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('station_id')}}</p>
    
  </div>
  
  
  
  
     <div class="form-group">
  {{ Form::label('max_temp')}}
  @if(isset($data['max_temp']))
  {{
  	 Form::text('max_temp', $data['max_temp'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('max_temp', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('max_temp')}}</p>
  
  
  </div>
  
  
         <div class="form-group">
  {{ Form::label('min_temp')}}
  @if(isset($data['min_temp']))
  {{
  	 Form::text('min_temp', $data['min_temp'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('min_temp', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('min_temp')}}</p>
  
  
  </div>
  
  
         <div class="form-group">
  {{ Form::label('rain')}}
  @if(isset($data['rain']))
  {{
  	 Form::text('rain', $data['rain'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('rain', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('rain')}}</p>
  
  
  </div>
  
  
  
         <div class="form-group">
  {{ Form::label('avgrh')}}
  @if(isset($data['avgrh']))
  {{
  	 Form::text('avgrh', $data['avgrh'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('avgrh', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('avgrh')}}</p>
  
  
  </div>
  
  
  
         <div class="form-group">
  {{ Form::label('evapor')}}
  @if(isset($data['evapor']))
  {{
  	 Form::text('evapor', $data['evapor'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('evapor', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('evapor')}}</p>
  
  
  </div>
  
  
         <div class="form-group">
  {{ Form::label('mean_temp')}}
  @if(isset($data['mean_temp']))
  {{
  	 Form::text('mean_temp', $data['mean_temp'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('mean_temp', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('mean_temp')}}</p>
  
  
  </div>
  
       <div class="form-group">
  {{ Form::label('source')}}
  @if(isset($data['source']))
  {{
  	 Form::text('source', $data['source'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('source', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('source')}}</p>
  
  
  </div>
  
         <div class="form-group">
  {{ Form::label('meas_year')}}
  @if(isset($data['meas_year']))
  {{
  	 Form::text('meas_year', $data['meas_year'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('meas_year', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
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
  {{ Form::label('meas_day')}}
  @if(isset($data['meas_day']))
  {{
  	 Form::text('meas_day', $data['meas_day'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('meas_day', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('meas_day')}}</p>
  
  
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



