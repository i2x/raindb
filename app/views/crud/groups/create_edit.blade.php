@extends('submenu')

{{-- Content --}}
@section('content')

@if($ampher_message != NULL){{$ampher_message}}
@endif



@if(isset($data['AMPHUR_ID']))
{{ Form::open(array('url' => URL::to('database/groups/'.$data['id'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/amphur/create') )) }}
@endif

	
   <div class="form-group">
  {{ Form::label('id')}}
  @if(isset($data['id']))
  
  {{ Form::text('id', $data['id'],array( 'class' => 'form-control', 'placeholder' => 'Enter id'  )) }}
 
  @else
 
  {{ Form::text('id','',array( 'class' => 'form-control', 'placeholder' => 'Enter id'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('id')}}</p>
   
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
  {{ Form::label('permissions')}}
  @if(isset($data['permissions']))
  {{
  	 Form::text('permissions', $data['permissions'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter permissions'  ))
  }}
  @else
  {{ 
  
  	Form::text('permissions', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter permissions'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('permissions')}}</p>
    
  </div>
  
  
  
  
     <div class="form-group">
  {{ Form::label('created_at')}}
  @if(isset($data['created_at']))
  {{
  	 Form::text('created_at', $data['created_at'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter created_at'  ))
  }}
  @else
  {{ 
  
  	Form::text('created_at', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter created_at'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('created_at')}}</p>
  
  
  </div>
  
  
  
       <div class="form-group">
  {{ Form::label('updated_at')}}
  @if(isset($data['updated_at']))
  {{
  	 Form::text('updated_at', $data['updated_at'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter updated_at'  ))
  }}
  @else
  {{ 
  
  	Form::text('updated_at', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter updated_at'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('updated_at')}}</p>
  
  
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



