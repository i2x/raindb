@extends('submenu')

{{-- Content --}}
@section('content')

@if($ampher_message != NULL){{$ampher_message}}
@endif

				

@if(isset($data['idtbl_ref_settings']))
{{ Form::open(array('url' => URL::to('database/tbl_ref_settings/'.$data['idtbl_ref_settings'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/tbl_ref_settings/create') )) }}
@endif

	
   <div class="form-group">
  {{ Form::label('idtbl_ref_settings')}}
  @if(isset($data['idtbl_ref_settings']))
  
  {{ Form::text('idtbl_ref_settings', $data['idtbl_ref_settings'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('idtbl_ref_settings','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('idtbl_ref_settings')}}</p>
   
  </div>
  
    
  
  
     <div class="form-group">
  {{ Form::label('basin_id')}}
  @if(isset($data['basin_id']))
  {{
  	 Form::text('basin_id', $data['basin_id'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('basin_id', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('basin_id')}}</p>
    
  </div>
  
  
  
  
     <div class="form-group">
  {{ Form::label('reftype')}}
  @if(isset($data['reftype']))
  {{
  	 Form::text('reftype', $data['reftype'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('reftype', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('reftype')}}</p>
  
  
  </div>
  
  
  
     <div class="form-group">
  {{ Form::label('varname')}}
  @if(isset($data['varname']))
  
  {{ Form::text('varname', $data['varname'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('varname','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('varname')}}</p>
   
  </div>
  
  
     <div class="form-group">
  {{ Form::label('analysis_level')}}
  @if(isset($data['analysis_level']))
  
  {{ Form::text('analysis_level', $data['analysis_level'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('analysis_level','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('analysis_level')}}</p>
   
  </div>
  
  
  
  
     <div class="form-group">
  {{ Form::label('latitude_from')}}
  @if(isset($data['latitude_from']))
  
  {{ Form::text('latitude_from', $data['latitude_from'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('latitude_from','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('latitude_from')}}</p>
   
  </div>
  
  
  
     <div class="form-group">
  {{ Form::label('latitude_to')}}
  @if(isset($data['latitude_to']))
  
  {{ Form::text('latitude_to', $data['latitude_to'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('latitude_to','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('latitude_to')}}</p>
   
  </div>
  
  
  
     <div class="form-group">
  {{ Form::label('longtitude_from')}}
  @if(isset($data['longtitude_from']))
  
  {{ Form::text('longtitude_from', $data['longtitude_from'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('longtitude_from','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('longtitude_from')}}</p>
   
  </div>
  
  
  
  
     <div class="form-group">
  {{ Form::label('longtitude_to')}}
  @if(isset($data['longtitude_to']))
  
  {{ Form::text('longtitude_to', $data['longtitude_to'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('longtitude_to','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('longtitude_to')}}</p>
   
  </div>
  
  
  
     <div class="form-group">
  {{ Form::label('time_scale')}}
  @if(isset($data['time_scale']))
  
  {{ Form::text('time_scale', $data['time_scale'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('time_scale','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('time_scale')}}</p>
   
  </div>
  
  
  
     <div class="form-group">
  {{ Form::label('month_from')}}
  @if(isset($data['month_from']))
  
  {{ Form::text('month_from', $data['month_from'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('month_from','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('month_from')}}</p>
   
  </div>
  
  
  
  
     <div class="form-group">
  {{ Form::label('month_to')}}
  @if(isset($data['month_to']))
  
  {{ Form::text('month_to', $data['month_to'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('month_to','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('month_to')}}</p>
   
  </div>
  
  
  
     <div class="form-group">
  {{ Form::label('area_weight_grid')}}
  @if(isset($data['area_weight_grid']))
  
  {{ Form::text('area_weight_grid', $data['area_weight_grid'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('area_weight_grid','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('area_weight_grid')}}</p>
   
  </div>
  

  

     <div class="form-group">
  {{ Form::label('source_url')}}
  @if(isset($data['source_url']))
  
  {{ Form::text('source_url', $data['source_url'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('source_url','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('source_url')}}</p>
   
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



