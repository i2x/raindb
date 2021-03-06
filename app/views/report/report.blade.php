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




<?php 
$_month = $_week = '';
$_monthsum = $_weeksum = '';
$_monthavg = $_weekavg = '';
$_monthmin =  $_weekmin = '';
$_monthmax = $_weekmax = '';
if (isset($weekly))
{
	


	foreach ($weekly as $value)
	{
		if($value->_weekavg == NULL || $value->_weekmin == NULL)
		{
			
		}
		else 
		{
			
			$_week = $_week.',\''.$value->_year."-".$value->_month."\ (".$value->_week.")".'\'';
			$_weeksum = $_weeksum.','.$value->_weeksum;
			$_weekmax = $_weekmax.','.$value->_weekmax;
			$_weekmin = $_weekmin.','.$value->_weekmin;
			$_weekavg = $_weekavg.','.$value->_weekavg;
			
		}
	
		
	}
	



foreach ($monthly as $value)
{
	
	if(isset($value->_monthmin))
	{
	$jd=gregoriantojd($value->_month,1,1);
	
	$_month = $_month.',\''.jdmonthname($jd,0)." \'".substr($value->_year, 2).'\'';
	$_monthsum = $_monthsum.','.$value->_monthsum;
	$_monthavg = $_monthavg.','.$value->_monthavg;
	$_monthmin = $_monthmin.','.$value->_monthmin;
	$_monthmax = $_monthmax.','.$value->_monthmax;
	}
}
}




?>



	<div class="container">







	<ol class="breadcrumb">
  	<li><a href="#">Home</a></li>
  	<li class="active">Report</li>
	</ol>
	
	
			
		

		{{ Form::open(array('url' => 'report', 'method' => 'POST')) }}
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
				

@if (isset($weekly) )
	
			<!-- Render -->
	
	<ul class="nav nav-tabs" id="Tab_" >
	  	<li class="active"><a href="#rain" data-toggle="tab">Monthly</a></li>
	
  		<li ><a href="#temp" data-toggle="tab">Weekly</a></li>

		</ul>

		<div class="tab-content">
  				<div class="tab-pane fade in active" id="rain" >
  				
  				 <div id="container2" ></div>
  				 <div id="boxplot2" ></div>
 		
 				
				</div>
				<div class="tab-pane fade " id="temp">
				
				
			    <div id="container"  style="width:84.5%" ></div>
 				<div id="boxplot1"  style="width:84.5%" ></div>
				
				

  				
				</div>
		</div>
@endif

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
            zoomType: 'x'
                
        },
        title: {
            text: 'Weekly '
        },
        subtitle: {
            text: ' '
        },
        xAxis: {
            categories: [<?php echo substr($_week,1) ?>],
	                    
                	
        },

        yAxis: {
            title: {
                text: 'rainfall (mm)'
            }
        },

        series: [{
            name: 'Avg',
            data: [<?php echo substr($_weekavg,1) ?>]

        },{
            name: 'Min',
            data: [<?php echo substr($_weekmin,1) ?>]
       },


       {
           name: 'Max',
           data: [<?php echo substr($_weekmax,1) ?>]
       },

         {
            name: 'Sum',
            data: [<?php echo substr($_weeksum,1) ?>]

        }, 



        ]
    });


    $('#boxplot1').highcharts({

	    chart: {
	        type: 'boxplot',
            zoomType: 'x'
    	        
	    },
	    
	    title: {
	        text: '  '
	    },
	    
	    legend: {
	        enabled: false
	    },
	
	    xAxis: {
	        categories: <?php echo $categories_boxplot_week?>,
	       	minTickInterval: 10,                 
	    	    	
	        title: {
	        }
	    },
	    
	    yAxis: {
	        title: {
	            text: 'rainfall (mm)'
	        },
	        plotLines: [{
	            value: 932,
	            color: 'red',
	            width: 1,
	            label: {
	                text: 'Theoretical mean: 932',
	                align: 'center',
	                style: {
	                    color: 'gray'
	                }
	            }
	        }]  
	    },
	
	    series: [{
	        name: 'Observations',
	        data:<?php echo $boxplot_week?>,
	        tooltip: {
	            headerFormat: '<em>Experiment No {point.key}</em><br/>'
	        }
	    }, ]
	
	});



    
});







$(function () {





	    
    $('#container2').highcharts({
        chart: {
            type: 'column',
            zoomType: 'x'
                
        },
        title: {
             text: '<?php

             	if ($oldInput['station'] != NULL )
             	{
             	$stationName = Station::select('name')->where('stationid' ,$oldInput['station'] )->get();
             	try {
             		echo $stationName[0]->name;
             	} catch (Exception $e) {

             	}
         
             	}?> '
        },
        
        subtitle: {

           

            
            text:  '<?php

                
                	if(isset($oldInput['start'])){

						echo ' start: ';
						echo '<code>'.$oldInput['start'].'</code>';
						}
                	
                	
                	if(isset($oldInput['end'])){
                	
                		echo ' end: ';
                		echo '<code>'.$oldInput['end'].'</code>';
                	}
                	
        		
                	else 
                	{
                		echo '<code>example</code>';
                	}
                	
                	?>'
        },
        xAxis: {
            categories: [<?php echo substr($_month,1) ?>],
            minTickInterval: 4                      
            
        
        },


        yAxis: {
            title: {
                text: 'rainfall (mm) '
            }
        },

        
        series: [{
            name: 'Avg',
            data: [<?php echo substr($_monthavg,1) ?>]

        },{
            name: 'Min',
            data: [<?php echo substr($_monthmin,1) ?>]
        },

  

        {
            name: 'Max',
            data: [<?php echo substr($_monthmax,1) ?>]
        },

        {
            name: 'Sum',
            data: [<?php echo substr($_monthsum,1) ?>]

        }, 


        ]
    });


    $('#boxplot2').highcharts({

	    chart: {
	        type: 'boxplot',
	            zoomType: 'x'
			        
	    },
	    
	    title: {
	        //text: 'Box Plot Monthly'
	    	text: ' '
	    },
	    
	    legend: {
	        enabled: false
	    },
	
	    xAxis: {
	        categories: <?php echo $categories_boxplot_month?>,
	        title: {
	        },
        	minTickInterval: 4                    
    	
	    },
	    
	    yAxis: {
	        title: {
	            text: 'rainfall (mm)'
	        },
	   
	    },
	
	    series: [{
	        name: 'Rain',
	        data:<?php echo $boxplot_month?>,
	        tooltip: {

	            valueSuffix: ' mm'
			        
	        }
	    }]
	
	});
    
});




$(document).ready(function(){

	$('.input-group.date').datepicker({
	    format: "yyyy-mm-dd",
	    autoclose: true
	    
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