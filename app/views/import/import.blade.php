@extends('master')
@section('title', 'Imoport')

@section('content')

{{ HTML::script('assets/js/jquery-1.11.1.min.js')}}
{{ HTML::style('packages/jasny/css/jasny-bootstrap.min.css')}}
{{ HTML::script('packages/jasny/js/jasny-bootstrap.min.js')}}










	<ol class="breadcrumb">
  	<li><a href="#">Home</a></li>
  	<li class="active">Import</li>
	</ol>

	
	
	
	<?php 
	if ($errors->first('file') != NULL)echo "<div class='alert alert-danger' role='alert'>".$errors->first('file') ."</div>";
	echo $message;
	
	
	
	?>
	

	



{{ Form::open(array('url' => 'import','files' => true)) }}


<div class="col-md-8">
<div class="fileinput fileinput-new input-group" data-provides="fileinput">
  <div class="form-control" data-trigger="fileinput">
  <i class="glyphicon glyphicon-file fileinput-exists"></i> 
  <span class="fileinput-filename"></span></div>
  <span class="input-group-addon btn btn-default btn-file">
  <span class="fileinput-new"><span class="glyphicon glyphicon-search"> </span>
   </span><span class="fileinput-exists">
   
    <a>  <span class="glyphicon glyphicon-repeat"></a>
   
   </span><input type="file" name="file"></span>
  <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">
  
  <span class="glyphicon glyphicon-remove-circle">
  
  
  </a>
</div>

</div>

<div class="row">


<?php echo Form::button('<i class="glyphicon glyphicon-upload"></i> Upload',
		 array('class' => 'btn btn-primary btn-sm','id' => 'submit','type'=>'submit'))?>
</div>
{{ Form::close() }}




@endsection


@section('scripts')
 
<script type="text/javascript">

$(document).ready(function(){

	$('#file').change(function(){


		var fileInput = $('#file');
		console.log(fileInput.val());

		$("#upload-file-info").html("<code>"+"<span class=\"glyphicon glyphicon-file\"></span>"+$(this).val())+"</code>";

		});


	
})


</script>
	
@endsection	
