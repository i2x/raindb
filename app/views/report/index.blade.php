<title>Rain - Report</title>
{{View::make('master')}}

{{ HTML::script('packages/jquery/jquery.min.js'); }}
{{ HTML::style('packages/chosen/chosen.min.css')}}
{{ HTML::script('packages/chosen/chosen.jquery.min.js')}}
{{ HTML::script('packages/highcharts/js/highcharts.js')}}
{{ HTML::script('packages/highcharts/js/modules/exporting.js')}}
{{ HTML::script('packages/highcharts/js/highcharts-more.js')}}


{{ HTML::script('packages/datepicker/js/bootstrap-datepicker.js')}}
{{ HTML::style('packages/datepicker/css/datepicker3.css')}}

	<div class="container">







	<ol class="breadcrumb">
  	<li><a href="#">Home</a></li>
  	<li class="active">Graph</li>
	</ol>
	
	
			
		
	<?php 
	
	//if(isset($oldInput))print_r($oldInput);
	?>
		{{ Form::open(array('url' => 'report', 'method' => 'POST')) }}
	<div class="col-md-12 ">
		
				<div class="row">

		
				<div class="col-md-2 column">
				{{ Form::select('basin',array(''=>'') + Riverbasin::lists('basin_name','basin_id'),
				isset($oldInput['basin']) ? $oldInput['basin'] : null ,
				array('class'=>'chosen-select','data-placeholder'=>'Select basin','id'=>'basin','style'=>"width: 160px;"))}}
				</div>
				
				
				<div class="col-md-2 column">
				{{ Form::select('province',array(''=>'') + Province::lists('province_name','province_id'),
				isset($oldInput['province']) ? $oldInput['province'] : null ,
				array('class'=>'chosen-select','data-placeholder'=>'Select Province','id'=>'province','style'=>"width: 160px;"))}}
				</div>
	
				
				<div class="col-md-2 column">
			
				{{ Form::select(
				'ampher',array(''=>'')+Ampher::lists('name','ampher_id'),
				isset($oldInput['ampher']) ? $oldInput['ampher']  : null ,
				array('class'=>'chosen-select','data-placeholder'=>
				'Select Amphur'
				
				,'id'=>'ampher','style'=>"width: 160px;"))}}
				</div>
				
				<div class="col-md-2 column">
			
				{{ Form::select('station',array(''=>'')+Station::lists('name','stationid'),
				isset($oldInput['station']) ? $oldInput['station']  : null 
				,
				array('class'=>'chosen-select',
				'data-placeholder'=>'Select Station',
				'id'=>'station','style'=>"width: 160px;"))}}
				
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
				

<script type="text/javascript">


$(document).ready(function(){

	$('.input-group.date').datepicker({
	    format: "yyyy-mm-dd"
	});
	


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
		
		$.ajax({
			type:'POST',
			url:"station",
			data:{id:value},
			success:function(data){
				
				$('#station').find('option')
							  .remove()
							  .end()
							  .append(data)
							  .trigger('chosen:updated');
				
			}
		});
	});

});





		</script>
	



