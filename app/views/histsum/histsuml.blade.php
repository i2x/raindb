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

		{{ Form::open(array('url' => 'historical', 'method' => 'POST')) }}
		<div class="col-md-12 ">
		
				<div class="row">

		
				<div class="col-md-2 column">
				
				
				{{ Form::select('basin',array(''=>'') + Riverbasin::lists('basin_name','basin_id'),
				isset($oldInput['basin']) ? $oldInput['basin'] : null ,
				array('class'=>'chosen-select','data-placeholder'=>'Select basin','id'=>'basin','style'=>"width: 160px;"))}}
				
				
				
				
				
				</div>
				<?php 
				
				?>
				
				<div class="col-md-2 column">
				
				@if($oldInput['basin'] != NULL)
				
				{{ Form::select('province',array(''=>'')+SelectController::save_province($oldInput['basin'])
				,
				isset($oldInput['province']) ? $oldInput['province'] : null 
				,
				array('class'=>'chosen-select','data-placeholder'=>'Select Province','id'=>'province','style'=>"width: 160px;"))}}
				@else
				
				{{ Form::select('province',array(''=>'') + Province::lists('province_name','province_id'),
				isset($oldInput['province']) ? $oldInput['province'] : null ,
				array('class'=>'chosen-select','data-placeholder'=>'Select Province','id'=>'province','style'=>"width: 160px;"))}}
				
				@endif
				
				
				</div>

				
				<div class="col-md-2 column">
			
				@if($oldInput['province'] != NULL)
				
				{{ Form::select(
				'ampher',array(''=>'')+SelectController::save_amphur($oldInput['province']),
				isset($oldInput['ampher']) ? $oldInput['ampher']  : null ,
				array('class'=>'chosen-select','data-placeholder'=>
				'Select Amphur'
				
				,'id'=>'ampher','style'=>"width: 160px;"))}}
				
				@else
				
				
				{{ Form::select(
				'ampher',array(''=>''),
				isset($oldInput['ampher']) ? $oldInput['ampher']  : null ,
				array('class'=>'chosen-select','data-placeholder'=>
				'Select Amphur'
				
				,'id'=>'ampher','style'=>"width: 160px;"))}}
				
				@endif
			
				
				</div>
				
				<div class="col-md-2 column">
				
				@if($oldInput['ampher'] != NULL)
			
				
				{{ Form::select('station',array(''=>'')+SelectController::save_station($oldInput['ampher']),
				isset($oldInput['station']) ? $oldInput['station']  : null 
				,
				array('class'=>'chosen-select',
				'data-placeholder'=>'Select Station',
				'id'=>'station','style'=>"width: 160px;"))}}
				
				
				@else
				
				
				{{ Form::select('station',array(''=>''),
				isset($oldInput['station']) ? $oldInput['station']  : null 
				,
				array('class'=>'chosen-select',
				'data-placeholder'=>'Select Station',
				'id'=>'station','style'=>"width: 160px;"))}}
				
				@endif
			
		
				
				</div>
				
		
				
				
								
			
				</div>
				
				<div class ="row">
				<br>
				<div class="col-md-2 column">
				
				<div class="input-group date">
				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
  				<input type="text" class="form-control"
  				name = "start"  placeholder = "Start Date"
  				<?php 
	 			if(isset($oldInput['start']))
   				 {
   				 	if(!empty($oldInput['start']))echo " value = ". $oldInput['start'];
   				 }
   				 
   				 ?>
  				
  				>
				</div>	
				
				
				
				</div>
				
					<div class="col-md-2 column">
				
				<div class="input-group date">
				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
  				<input type="text" class="form-control"
  				name = "end"  placeholder = "End Date"
  				<?php 
	 			if(isset($oldInput['end']))
   				 {
   				 	if(!empty($oldInput['end']))echo " value = ". $oldInput['end'];
   				 }
   				 
   				 ?>
  				
  				>
				</div>	
				
				
				
				</div>
				
				<div class="col-md-4 column">
				{{ Form::checkbox('only_rainy_day', 'true',
				isset($oldInput['only_rainy_day']) ? true : false 
				)}}
				{{Form::label('rainy_day', 'Only Rainy Day')}}
				
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
	
	
	

	
	

	<table id="gridview" class="table table-striped table-hover table-condensed" >
	
		<thead>
			<tr>
			
			
			
				<th class="col-md-3">Date</th>
				<th class="col-md-1">Station ID</th>
				<th class="col-md-4">Name</th>
				<th class="col-md-1">Max Temperature</th>
				<th class="col-md-1">Min Temperature</th>
				<th class="col-md-1">Rain(mm)</th>
				<th class="col-md-1">Average Relative Humidity</th>
				<th class="col-md-1">evapor</th>
				<th class="col-md-1">Mean Temperature</th>
				<th class="col-md-1">Source</th>
				
				
				
				
				
				
			</tr>
		</thead>
	</table>
	
	
	
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
	


	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
			$('.input-group.date').datepicker({
			    format: "yyyy-mm-dd",
			    autoclose: true
			    
			});
			oTable = $('#gridview').dataTable( {

				
				"oLanguage": {
					"sLengthMenu": "_MENU_"
				},
				"bProcessing": true,
		        "bServerSide": true,
		        "iDisplayLength": 25,
				"sAjaxSource": "{{ URL::to('historical/data') }}",
			
		    
			});

		});
	</script>
	
	
	
	
<script type="text/javascript">
$(document).ready(function(){

	$('.chosen-select').chosen();

	$('#basin').change(function(){
		var value = $("#basin").val();
		
		$.ajax({
			type:'POST',
			url:"province",
			data:{id:value},
			success:function(data){
				
				$('#province').find('option')
							  .remove()
							  .end()
							  .append(data)
							  .trigger('chosen:updated');
				
			}
		});
	});
	$('#province').change(function(){
		var value = $("#province").val();
		
		
		$.ajax({
			type:'POST',
			url:"ampher",
			data:{id:value},
			success:function(data){
				
				$('#ampher').find('option')
							  .remove()
							  .end()
							  .append(data)
							  .trigger('chosen:updated');
				
			}
		});
	});

	$('#ampher').change(function(){
		var value = $("#ampher").val();
		var province = $("#province").val();
		
		
	
		$.ajax({
			type:'POST',
			url:"station",
			data:{province:province,id:value},
			success:function(data){
				
				$('#station').find('option')
							  .remove()
							  .end()
							  .append(data)
							  .trigger('chosen:updated');
				
			}
		});
	});

	$('#station').change(function(){
		var value = $("#station").val();
	    $('#test').text(' ');
	});


});
</script>

@stop