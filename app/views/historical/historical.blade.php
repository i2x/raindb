@extends('master')
@section('title', 'Historical Data')

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

            <div class='col-md-12'>
        <button id='hideshow'>Hide/Show</button>
        <a class="btn" href="http://ssf.haii.or.th/raindb/public/index.php/historical">Clear</a>


            </div>
	<div id='searchform' class="col-md-12 "  style="display:none">
            {{ Form::open(array('url' => 'historical', 'method' => 'POST')) }}	
				<div class ="row">
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
  				/>
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
  				/>
				</div>	
				</div>
				<div class="col-md-3 column">
				{{ Form::checkbox('only_rainy_day', 'true',
				isset($oldInput['only_rainy_day']) ? true : false 
				)}}
				{{Form::label('rainy_day', 'Only Rainy Day')}}
				{{Form::submit('Submit', array())}}
				</div>	
				</div>
		  
			  <div class="row"><br/></div>
                          
				<div class="row">

                                
				<div class="col-md-3 column">
                                    Basin:<br/>
				{{ Form::select('basin[]',array(''=>'') + Riverbasin::lists('basin_name','basin_id'),
				isset($oldInput['basin']) ? $oldInput['basin'] : null ,
				array('multiple','data-placeholder'=>'Select basin','id'=>'basin','style'=>"width: 200px;height:280px"))}}
				</div>
				<!--'class'=>'chosen-select',-->
				
				<div class="col-md-3 column">
                                    Province:<br/>
				{{ Form::select('province[]',array(''=>'') + Province::lists('province_name','province_id'),
				isset($oldInput['province']) ? $oldInput['province'] : null ,
				array('multiple','data-placeholder'=>'Select Province','id'=>'province','style'=>"width: 200px;height:280px"))}}
				</div>
	
				
				<div class="col-md-3 column">
			Ampher:<br/>
				{{ Form::select(
				'ampher[]',array(''=>'')+Ampher::lists('name','ampher_id'),
				isset($oldInput['ampher']) ? $oldInput['ampher']  : null ,
				array('multiple','data-placeholder'=>
				'Select Amphur'
				
				,'id'=>'ampher','style'=>"width: 200px;height:280px"))}}
				</div>
				
				<div class="col-md-3 column">
			Station:<br/>
				{{ Form::select('station[]',array(''=>'')+Station::lists('name','stationid'),
				isset($oldInput['station']) ? $oldInput['station']  : null 
				,
				array('multiple',
				'data-placeholder'=>'Select Station',
				'id'=>'station','style'=>"width: 200px;height:280px"))}}
				
				</div>
									
				</div>
				

			  
                          
			   
			 {{ Form::close() }}
						
	</div>
				
				
                <div class='row'>
                    <div class='col-md-1'>
                    {{Input['basin'}}
                    </div>
                    <div class='col-md-1'>
                    {{Input['basin'}}
                    </div>
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

	//$('.chosen-select').chosen();
        
    $('#hideshow').click( function() {        
         $('#searchform').toggle('show');
    });
    
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