@extends('submenu')



 

{{-- Content --}}
@section('content')

@if($ampher_message != NULL){{$ampher_message}}
@endif


				

@if(isset($data['stationid']))
{{ Form::open(array('url' => URL::to('database/tbl_rain_station/'.$data['stationid'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/tbl_rain_station/create') )) }}
@endif

	
   <div class="form-group">
  {{ Form::label('stationid')}}
  @if(isset($data['stationid']))
  
  {{ Form::text('stationid', $data['stationid'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('stationid','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('stationid')}}</p>
   
  </div>
  
  
  <div class="form-group">
  {{ Form::label('name')}}
  @if(isset($data['name']))
  {{
  	 Form::text('name', $data['name'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @else
  {{ 
  
  	Form::text('name', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('name')}}</p>
    </div>

  
  
  
  
     <div class="form-group">
  {{ Form::label('latitude')}}
  @if(isset($data['latitude']))
  {{
  	 Form::text('latitude', $data['latitude'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('latitude', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('latitude')}}</p>
    
  </div>
  
  
  
  
     <div class="form-group">
  {{ Form::label('longtitude')}}
  @if(isset($data['longtitude']))
  {{
  	 Form::text('longtitude', $data['longtitude'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('longtitude', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('longtitude')}}</p>
  
  
  </div>
  
  
  
         <div class="form-group">
  {{ Form::label('msl')}}
  @if(isset($data['msl']))
  {{
  	 Form::text('msl', $data['msl'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('msl', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('msl')}}</p>
  
  
  </div>
  
         <div class="form-group">
  {{ Form::label('ampher')}}
  @if(isset($data['ampher']))
  {{
  	 Form::text('ampher', $data['ampher'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('ampher', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('ampher')}}</p>
  
  
  </div>
  
  
         <div class="form-group">
  {{ Form::label('province')}}
  @if(isset($data['province']))
  {{
  	 Form::text('province', $data['province'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('province', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('province')}}</p>
  
  
  </div>
  
         <div class="form-group">
  {{ Form::label('description')}}
  @if(isset($data['description']))
  {{
  	 Form::text('description', $data['description'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('description', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('description')}}</p>
  
  
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



