@extends('submenu')

{{-- Content --}}
@section('content')
{{ Form::open(array('url' => 'foo/bar')) }}

<?php 

print_r($data);
?>

 <div class="form-group">
    <label for="exampleInputEmail1">AMPHUR_CODE</label>
    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
  </div>
  
  
   <div class="form-group">
  <?php echo Form::label('AMPHUR_CODE')?>
  {{ Form::text('AMPHUR_CODE', 'example@gmail.com',
 
  array( 'class' => 'form-control', 'placeholder' => 'Enter Code'  ))
  
  }}
 

  </div>
  
  
  <div class="form-group">
    <label for="exampleInputPassword1">AMPHUR_NAME</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>

  <button type="submit" class="btn btn-default">Update</button>


{{ Form::close() }}
@stop



