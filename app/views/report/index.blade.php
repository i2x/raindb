<title>Rain - Report</title>
{{View::make('master')}}

{{ HTML::script('packages/jquery/jquery.min.js'); }}
{{ HTML::style('packages/chosen/chosen.min.css')}}
{{ HTML::script('packages/chosen/chosen.jquery.min.js')}}
{{ HTML::script('packages/highcharts/js/highcharts.js')}}
{{ HTML::script('packages/highcharts/js/modules/exporting.js')}}
{{ HTML::script('packages/highcharts/js/highcharts-more.js')}}


<div class="container">



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
	$_week = $_week.','.$value->_week;
	$_weeksum = $_weeksum.','.$value->_weeksum;
	$_weekavg = $_weekavg.','.$value->_weekavg;
	$_weekmin = $_weekmin.','.$value->_weekmin;
	$_weekmax = $_weekmax.','.$value->_weekmax;
}



foreach ($monthly as $value)
{
	$_month = $_month.','.$value->_month;
	$_monthsum = $_monthsum.','.$value->_monthsum;
	$_monthavg = $_monthavg.','.$value->_monthavg;
	$_monthmin = $_monthmin.','.$value->_monthmin;
	$_monthmax = $_monthmax.','.$value->_monthmax;
}
}



?>


	<ol class="breadcrumb">
  	<li><a href="#">Home</a></li>
  	<li class="active">Graph</li>
	</ol>
	
	
			
			<?php 
		
			$data = HistoricData::select(array('mean_temp','meas_date','rain'))->limit(360)->get();
			$graph = ' ';
			$mean_temp = ' ';
			$data_list = ' ';
			for($i=0;$i < sizeof($data);$i++)
			{
				
				$yrdata= strtotime(($data[$i]['meas_date']));
				if($i == 0)
				{
					$graph = $graph.$data[$i]['rain'];
					$mean_temp =  $mean_temp.$data[$i]['mean_temp'];
					$data_list = $data_list.'"'.date('d M Y', $yrdata).'"';
				}
				else 
				{
				$graph = $graph.','.$data[$i]['rain'];
				$mean_temp = $mean_temp.','.$data[$i]['mean_temp'];
				$data_list = $data_list.',"'.date('d M Y', $yrdata).'"';
				
				}
					
			}
			
			?>
			

			

		{{ Form::open(array('url' => 'report', 'method' => 'POST')) }}
	<div class="col-md-12 ">
		
				<div class="row">
				<div class="col-md-2 column">
				{{ Form::select('province',array(''=>'') + Province::lists('PROVINCE_NAME','PROVINCE_ID'),null,
				array('class'=>'chosen-select','data-placeholder'=>'เลือกจังหวัด','id'=>'province','style'=>"width: 160px;"))}}
				</div>
	
				
				<div class="col-md-2 column">
				{{ Form::select('ampher',array(''=>''),null,
				array('class'=>'chosen-select','data-placeholder'=>'เลือกอำเภอ','id'=>'ampher','style'=>"width: 160px;"))}}
				</div>
				
				<div class="col-md-2 column">
				{{ Form::select('station',array(''=>''),null,
				array('class'=>'chosen-select','data-placeholder'=>'เลือกสถานี','id'=>'station','style'=>"width: 160px;"))}}
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
	  	<li class="active"><a href="#rain" data-toggle="tab">Weekly</a></li>
	
  		<li ><a href="#temp" data-toggle="tab">Monthly</a></li>

		</ul>

		<div class="tab-content">
  				<div class="tab-pane fade in active" id="rain" >
 				<div id="container" ></div>
 				<div id="boxplot1" ></div>
 				
				</div>
				<div class="tab-pane fade " id="temp">
  				<div id="container2"  "     style="width:84.5%;"></div>
  				 <div id="boxplot2"  style="width:84.5%;"></div>
  				
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
            categories: [<?php echo substr($_week,1) ?>]
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
	        type: 'boxplot'
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
	        data: [
	            [760, 801, 848, 895, 965],
	            [733, 853, 939, 980, 1080],
	            [714, 762, 817, 870, 918],
	            [724, 802, 806, 871, 950],
	            [834, 836, 864, 882, 910]
	        ],
	        tooltip: {
	            headerFormat: '<em>Experiment No {point.key}</em><br/>'
	        }
	    }, {
	        name: 'Outlier',
	        color: Highcharts.getOptions().colors[0],
	        type: 'scatter',
	        data: [ // x, y positions where 0 is the first category
	            [0, 644],
	            [4, 718],
	            [4, 951],
	            [4, 969]
	        ],
	        marker: {
	            fillColor: 'white',
	            lineWidth: 1,
	            lineColor: Highcharts.getOptions().colors[0]
	        },
	        tooltip: {
	            pointFormat: 'Observation: {point.y}'
	        }
	    }]
	
	});



    
});








$(function () {

	
    $('#container2').highcharts({
        chart: {
            type: 'column',
            zoomType: 'x'
                
        },
        title: {
            text: 'Monthly '
        },
        subtitle: {
            text: ' '
        },
        xAxis: {
            categories: [<?php echo substr($_month,1) ?>]
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
	        type: 'boxplot'
	    },
	    
	    title: {
	        text: 'Box Plot Monthly'
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
	        data: [
	            [760, 801, 848, 895, 965],
	            [733, 853, 939, 980, 1080],
	            [714, 762, 817, 870, 918],
	            [724, 802, 806, 871, 950],
	            [834, 836, 864, 882, 910]
	        ],
	        tooltip: {
	            headerFormat: '<em>Experiment No {point.key}</em><br/>'
	        }
	    }, {
	        name: 'Outlier',
	        color: Highcharts.getOptions().colors[0],
	        type: 'scatter',
	        data: [ // x, y positions where 0 is the first category
	            [0, 644],
	            [4, 718],
	            [4, 951],
	            [4, 969]
	        ],
	        marker: {
	            fillColor: 'white',
	            lineWidth: 1,
	            lineColor: Highcharts.getOptions().colors[0]
	        },
	        tooltip: {
	            pointFormat: 'Observation: {point.y}'
	        }
	    }]
	
	});
    
});




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
	



