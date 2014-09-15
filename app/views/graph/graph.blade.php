<title>Rain - Graph</title>
{{View::make('master')}}

{{ HTML::script('packages/jquery/jquery.min.js'); }}
{{ HTML::style('packages/chosen/chosen.min.css')}}
{{ HTML::script('packages/chosen/chosen.jquery.min.js')}}
{{ HTML::script('packages/highcharts/js/highcharts.js')}}
{{ HTML::script('packages/highcharts/js/modules/exporting.js')}}
{{ HTML::script('packages/datepicker/js/bootstrap-datepicker.js')}}
{{ HTML::style('packages/datepicker/css/datepicker3.css')}}



<div class="container">




	<ol class="breadcrumb">
  	<li><a href="#">Home</a></li>
  	<li class="active">Graph</li>
	</ol>
	
	
	
	<?php 
            
            		try {
					$test = Station::where('stationid','=',$oldInput['station'])->get();
					foreach ($test as $value)

					$graphTitle= '\''.$value->name.'\'';
					$graphSubtitle = '\'start: '.$oldInput['start'].'   end:'.
					$oldInput['end'].'\'';
            			
            		} catch (Exception $e) {
					$graphTitle = '\'N/A\'';
					$graphSubtitle = '\'N/A\'';
            		}
            		
            		
            		?>	
	
	
		

	{{ Form::open(array('url' => 'graph', 'method' => 'POST')) }}
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
				
				




	<ul class="nav nav-tabs" id="Tab_" >
	  	<li class="active"><a href="#rain" data-toggle="tab">Rainfall (mm.)</a></li>
	
  		<li ><a href="#temp" data-toggle="tab">Temperature(°C)</a></li>

		</ul>

		<div class="tab-content">
  				<div class="tab-pane fade in active" id="rain" >
 				<div id="container" ></div>
				</div>
				<div class="tab-pane fade " id="temp">
  				<div id="container2"  "     style="width:84.5%;"></div>
				</div>
		</div>

<script type="text/javascript" charset="UTF-8">
$(function () {
    $('#container').highcharts({
        chart: {
            zoomType: 'x'
                
        },

        exporting: {

        	buttons: { 
            
                printButton: {
                    enabled:false
                }

            }
        },
        
        title: {
            text: <?php echo $graphTitle ?>	,
            		  style: {
            	            "font-family":'verdana'
            	    },
        },
        subtitle: {
            text:<?php echo $graphSubtitle?>	
        },

        tooltip: {
            valueSuffix: '(mm)'
        },
        xAxis: {
     

        	categories: [<?php echo $data['date_list']?>],
        	minTickInterval: 30                     
    	
        
        },
        yAxis: {
            title: {
                text: 'rainfall (mm.)'
            }
        },
        legend: {
            enabled: false
        },
        

        
        plotOptions: {

            
            area: {
				
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                    stops: [
                        [0, Highcharts.getOptions().colors[0]],
                        [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                    ]
                },
                marker: {
                    radius: 2
                },
                lineWidth: 1,
                states: {
                    hover: {
                        lineWidth: 1
                    }
                },
                
                
            }
        },

        series: [{
            type: 'area',
            name: 'rainfall',
       
            data: [<?php echo $data['graph']?>]
        }]
    });
});



$(function () {

	
    $('#container2').highcharts({
        chart: {
            zoomType: 'x'
            
        },

        colors: ['#ff371c', '#0d233a', '#8bbc21', '#910000', '#1aadce', 
                 '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a'],
        title: {
            text: <?php echo $graphTitle ?>	
        },
        subtitle: {
            text:<?php echo $graphSubtitle ?>	
        },

        tooltip: {
            valueSuffix: '(°C)'
        },

        plotOptions: {

            animation: false,
        	line: {
        	        marker: {
        	            enabled: false,
        	            
        	        },

        	        lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },

        	    }


	    
        },

       
        xAxis: {
     

        	categories: [<?php echo $data['date_list']?>],
        	minTickInterval: 30                     
        	                   
        	                    
    	
        
        },
        yAxis: {
            title: {
                text: 'temperature(°C)'
            }
        },
        

        series: [{
            type: 'line',
            name: 'mean',
            
       
            data: [<?php echo $data['mean_temp']?>]
        }]
    });
});




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
	




