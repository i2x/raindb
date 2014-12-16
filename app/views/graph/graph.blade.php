<title>Rain - Graph & Report</title>
{{View::make('master')}}

{{ HTML::script('packages/jquery/jquery.min.js'); }}
{{ HTML::style('packages/chosen/chosen.min.css')}}
{{ HTML::script('packages/chosen/chosen.jquery.min.js')}}
{{ HTML::script('packages/highcharts/js/highcharts.js')}}
{{ HTML::script('packages/highcharts/js/highcharts-more.js')}}

{{ HTML::script('packages/highcharts/js/modules/exporting.js')}}
{{ HTML::script('packages/datepicker/js/bootstrap-datepicker.js')}}
{{ HTML::style('packages/datepicker/css/datepicker3.css')}}





<div class="container">




	<ol class="breadcrumb">
  	<li><a href="#">Home</a></li>
  	<li class="active">Graph &  Report</li>
	</ol>
	
	
	
	<?php 
                    $graphTitle="'";
            
            		try {
					$test = Station::whereIn('stationid',$oldInput['station'])->get();
					foreach ($test as $value){
                                            $graphTitle=  $graphTitle.$value->name.'('.$value->stationid.')'.' ';
                                        }
                                        
                                        $graphTitle=  $graphTitle."'";
                                        
					$graphSubtitle = '\'start: '.$oldInput['start'].'   end:'.
					$oldInput['end'].'\'';
            			
            		} catch (Exception $e) {
					$graphTitle = '\'N/A\'';
					$graphSubtitle = '\'N/A\'';

                        }
            		
            		?>	
	
<?php 
// report block

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
			
			$_week = $_week.',\''.$value->_year."-".$value->_month."-".$value->_day."\ (".$value->_week.")".'\'';
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
	
		

            <div class='col-md-12'>
        <button id='hideshow'>Hide/Show</button>
        <a class="btn" href="http://ssf.haii.or.th/raindb/public/index.php/graph">Clear</a>


            </div>
	<div id='searchform' class="col-md-12 " style="display:none">
            {{ Form::open(array('url' => 'graph', 'method' => 'POST')) }}	
				<div class ="row">
				<div class="col-md-2 column">
				<div class="input-group date">
				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
  				<input type="text" class="form-control"
  				name = "start"  placeholder = "*Start Date"
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
  				name = "end"  placeholder = "*End Date"
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
				




	<ul class="nav nav-tabs" id="Tab_" >
	  	<li class="active"><a href="#rain" data-toggle="tab">Rainfall (mm.)</a></li>
	
  		<li ><a href="#temp" data-toggle="tab">Temperature(°C)</a></li>

		</ul>

		<div class="tab-content">
  				<div class="tab-pane fade in active" id="rain" >
 				<div id="raingraph" ></div>
				</div>
				<div class="tab-pane fade " id="temp">
  				<div id="tempgraph"      style="width:84.5%;"></div>
				</div>
		</div>

<script type="text/javascript" charset="UTF-8">
$(function () {
    $('#raingraph').highcharts({
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
            	            "font-family":'verdana',
                            "font-size": "16px"
            	    },
        },
        subtitle: {
            text:<?php echo $graphSubtitle?>	
        },

        tooltip: {
            valueSuffix: '(mm)'
        },
        xAxis: {
     


        type: 'datetime',
        labels: {
            format: '{value:%Y-%m-%d}',
            rotation: 60,
            align: 'left'
        }                    
    	
        
        },
        yAxis: {
            title: {
                text: 'rainfall (mm.)'
            }
        },
        legend: {
            enabled: true
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

        series: [
<?php 
$icount = 0;
$stationss = $oldInput['station'];
foreach($data['graphs'] as $g){ 

    ?>
    {
            type: 'area',
            name: 'ID{{$stationss[$icount]}}',
            pointStart: Date.UTC({{$data['date_year']}}, {{$data['date_month']-1}}, {{$data['date_day']}}),
            pointInterval: 24 * 36e5,      
            data: [<?php echo $g; $icount++;?>]
        },
<?php } ?>       
    ]
    });
});



$(function () {

	
    $('#tempgraph').highcharts({
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
     

        type: 'datetime',
        labels: {
            format: '{value:%Y-%m-%d}',
            rotation: 60,
            align: 'left'
        }        	                   
        	                    
    	
        
        },
        yAxis: {
            title: {
                text: 'temperature(°C)'
            }
        },
        

        series: [{
            type: 'area',
            name: 'mean',
            pointStart: Date.UTC({{$data['date_year']}}, {{$data['date_month']-1}}, {{$data['date_day']}}),
            pointInterval: 24 * 36e5,      
            
       
            data: [<?php echo $data['mean_temps'][0]?>]
        }]
    });
});

</script>

@if (isset($weekly) )
	
	
	<ul class="nav nav-tabs" id="Tab2_">
	  	<li class="active"><a href="#motab" data-toggle="tab">Monthly</a></li>
	
  		<li ><a href="#weeklytab" data-toggle="tab">Weekly</a></li>

		</ul>

		<div class="tab-content">
  				<div class="tab-pane fade in active" id="motab" >
  				
  				 <div id="monthlyreport" ></div>
  				 <div id="monthlyboxplot" ></div>
 		
 				
				</div>
				<div class="tab-pane fade " id="weeklytab">
				
				
			    <div id="weeklyreport"  style="width:84.5%" ></div>
 				<div id="weeklyboxplot"  style="width:84.5%" ></div>
				
				

  				
				</div>
		</div>

<script type="text/javascript">
$(function () {
    $('#weeklyreport').highcharts({
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


    $('#weeklyboxplot').highcharts({

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
	        categories: <?php echo $categories_boxplot_week?> ,
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





	    
    $('#monthlyreport').highcharts({
        chart: {
            type: 'column',
            zoomType: 'x'
                
        },
        title: {
             text: '<?php

             	if ($oldInput['station'] != NULL )
             	{
             	$stationNames = Station::select('name')->whereIn('stationid' ,$oldInput['station'] )->get();
             	try {
                    foreach($stationNames as $stationName)
             		echo $stationName->name. " ";
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


    $('#monthlyboxplot').highcharts({

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
</script>
@endif






<script type="text/javascript">

$(document).ready(function(){

	$('.input-group.date').datepicker({
	    format: "yyyy-mm-dd"
	});
	


	$('.chosen-select').chosen();

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
	




