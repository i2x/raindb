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
$_monthmin =  $_weekmin = $_weekmin2 = '';
$_monthmax = $_weekmax = '';
if (isset($weekly))
{
	
	
if(isset($only_rainy_day)){
foreach ($weekly as $value)
{

	if($value->_weekmin2 !=NULL)
	{

		$_week = $_week.','.$value->_week;
		$_weeksum = $_weeksum.','.$value->_weeksum;
		$_weekavg = $_weekavg.','.$value->_weekavg;
		$_weekmin = $_weekmin.','.$value->_weekmin2;
		$_weekmax = $_weekmax.','.$value->_weekmax;
	}
}
	
}
else 
{
	foreach ($weekly as $value)
	{
	
		
	
			$_week = $_week.',\''.$value->_week."\'".substr($value->_year, 2).'\'';
			$_weeksum = $_weeksum.','.$value->_weeksum;
			$_weekavg = $_weekavg.','.$value->_weekavg;
			$_weekmin = $_weekmin.','.$value->_weekmin;
			$_weekmax = $_weekmax.','.$value->_weekmax;
		
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
       		 minTickInterval: 10                      
    	
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
	        text: ' Box Weekly'
	    },
	    
	    legend: {
	        enabled: false
	    },
	
	    xAxis: {
	        categories: ['1', '2', '3', '4', '5'],
	        title: {
	            text: 'Experiment No.'
	        }
	    },
	    
	    yAxis: {
	        title: {
	            text: 'Observations'
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
	        data:<?php echo $test?>,
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

             	if (isset($oldInput['station'] ))
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
	        categories: <?php echo $categories_boxplot1?>,
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
	        data:<?php echo $test?>,
	        tooltip: {

	            valueSuffix: ' mm'
			        
	        }
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
	 <?php echo floor( sizeof($monthly)/12)?>			
	
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
	



