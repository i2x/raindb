@extends('master')
@section('title', 'Histoorical Data')

{{-- Content --}}
@section('content')



	<ol class="breadcrumb">
  	<li><a href="#">Home</a></li>
  	<li class="active">Historical Data</li>
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
	{{ Form::open(array('url' => 'historical')) }}
	<div class="col-md-12 ">
	
	
		
				<div class="row">
				<div class="col-md-2 column">
		        <label >Province</label>
		        
		       
				{{ Form::select('province',array(''=>'') + Province::lists('province_name','province_id'),null,
				array('class'=>'chosen-select','data-placeholder'=>'Select Province','id'=>'province','style'=>"width: 160px;"))}}
				</div>
	
				
				<div class="col-md-2 column">
				<label >Ampher</label>
				{{ Form::select('ampher',array(''=>''),null,
				array('class'=>'chosen-select','data-placeholder'=>'เลือกอำเภอ','id'=>'ampher','style'=>"width: 160px;"))}}
				</div>
				
				<div class="col-md-2 column">
				
				<label id="test"><font color="red">*</font></label><label >สถานี</label>
				
				{{ Form::select('station',array(''=>''),null,
				array('class'=>'chosen-select','data-placeholder'=>'เลือกสถานี','id'=>'station','style'=>"width: 160px;"))}}
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
			
			
			
				<th class="col-md-1">meas_id</th>
				<th class="col-md-2">meas_date</th>
				<th class="col-md-1">station_id</th>
				<th class="col-md-2">Name</th>
				<th class="col-md-1">max_temp</th>
				<th class="col-md-1">min_temp</th>
				<th class="col-md-1">rain</th>
				<th class="col-md-1">avgrh</th>
				<th class="col-md-1">evapor</th>
				<th class="col-md-1">mean_temp</th>
				
				
				
				
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
	{{ HTML::script('packages/datatables/js/dataTables.bootstrap.js')}}z
	


	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
			
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