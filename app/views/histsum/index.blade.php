@extends('master')
@section('title', 'Historical Summary')

{{-- Content --}}
@section('content')


	<ol class="breadcrumb">
  	<li><a href="#">Home</a></li>
  	<li class="active">Historical Summary</li>
	</ol>

	
	<!-- =======================================
	===============Selector Module ==============
	=============================================-->
	
	
	
    	<!-- warning message start -->
	<?php 
	if ($errors->first('station') != NULL)echo "<div class='alert alert-warning' role='alert'>".$errors->first('station') ."</div>";
	
	
	?>
	
	    <!-- warning message end-->
	
			
		<!-- DropDown Form start -->			

		{{ Form::open(array('url' => 'histsum', 'method' => 'POST')) }}
		<div class="col-md-12 ">
		
				<div class="row">

		
				<div class="col-md-2 column">
				
				
				{{ Form::select('basin',Riverbasin::lists('basin_name','basin_id')+array('Other'=>'Other'),
				isset($oldInput['basin']) ? $oldInput['basin'] : null ,
				array('class'=>'chosen-select','data-placeholder'=>'Select basin','id'=>'basin','style'=>"width: 160px;"))}}
				
				</div>
				<?php 
				
				?>
				
			
				</div>
				
				<div class ="row">
				<div class="col-md-4 column">
				{{ Form::checkbox('only_selected_station', 'true',
				isset($oldInput['only_selected_station']) ? true : false 
				)}}
				{{Form::label('selected_station', 'Only Selected Stations')}}
				
				</div>				
				
				</div>
				
				
				</div>
				
			
				
				<div class="row"> <br></div>
			  {{Form::submit('submit', array('class' => 'btn btn-primary btn-sm'))}}
			  
			  
			  <div class="row"> <br></div>
			  
			  
			   
			 {{ Form::close() }}
						
	</div>
				
				
	

	<br><br><br><br>
	
			<!-- DeopDown Form End -->			
	
	
	
	<div class="page-header">
		<h3>
		</h3>
	</div>
	

@stop



{{-- Style --}}

@section('style')
	
	{{ HTML::style('packages/chosen/chosen.min.css')}}
	{{ HTML::style('packages/datatables/css/dataTables.bootstrap.css')}}

@endsection

{{-- Scripts --}}
@section('scripts')

	{{ HTML::script('packages/jquery/jquery.min.js'); }}
	{{ HTML::script('packages/chosen/chosen.jquery.min.js')}}
	{{ HTML::script('packages/highcharts/js/highcharts.js')}}
	{{ HTML::script('packages/highcharts/js/modules/exporting.js')}}
   	{{ HTML::script('packages/datatables/js/jquery.dataTables.min.js')}}
	{{ HTML::script('packages/datatables/js/dataTables.bootstrap.js')}}
	
	
	{{ HTML::script('packages/datepicker/js/bootstrap-datepicker.js')}}
	{{ HTML::style('packages/datepicker/css/datepicker3.css')}}		
	


@stop