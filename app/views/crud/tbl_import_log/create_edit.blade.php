@extends('submenu')

{{-- Content --}}
@section('content')

@if($ampher_message != NULL){{$ampher_message}}
@endif


<?php 
print_r($data);

?>	

@if(isset($data['logid']))
{{ Form::open(array('url' => URL::to('database/amphur/'.$data['logid'].'/update') )) }}
@else
{{ Form::open(array('url' => URL::to('database/amphur/create') )) }}
@endif

	
   <div class="form-group">
  {{ Form::label('importdate')}}
  @if(isset($data['importdate']))
  
  {{ Form::text('importdate', $data['importdate'],array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @else
 
  {{ Form::text('importdate','',array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  )) }}
 
  @endif

  <p class="text-danger">{{$errors->first('importdate')}}</p>
   
  </div>
  
  
  <div class="form-group">
  {{ Form::label('filename')}}
  @if(isset($data['filename']))
  {{
  	 Form::text('filename', $data['filename'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @else
  {{ 
  
  	Form::text('filename', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter Name'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('filename')}}</p>
    </div>

  
  
  
  
     <div class="form-group">
  {{ Form::label('url')}}
  @if(isset($data['url']))
  {{
  	 Form::text('url', $data['url'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('url', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('url')}}</p>
    
  </div>
  
  
  
  
     <div class="form-group">
  {{ Form::label('message')}}
  @if(isset($data['message']))
  {{
  	 Form::text('message', $data['message'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('message', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('message')}}</p>
  
  
  </div>
  
  
     <div class="form-group">
  {{ Form::label('level')}}
  @if(isset($data['level']))
  {{
  	 Form::text('level', $data['level'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('level', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('level')}}</p>
  
  
  </div>
  
  
  
       <div class="form-group">
  {{ Form::label('detail')}}
  @if(isset($data['detail']))
  {{
  	 Form::text('detail', $data['detail'],
 	 array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @else
  {{ 
  
  	Form::text('detail', '',
 	array( 'class' => 'form-control', 'placeholder' => 'Enter ID'  ))
  }}
  @endif
  <p class="text-danger">{{$errors->first('detail')}}</p>
  
  
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



