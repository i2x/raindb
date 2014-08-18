<title>Rain - Forecase</title>
{{View::make('master')}}

{{ HTML::script('packages/jquery/jquery.min.js'); }}
{{ HTML::style('packages/chosen/chosen.min.css')}}
{{ HTML::script('packages/chosen/chosen.jquery.min.js')}}
{{ HTML::script('packages/highcharts/js/highcharts.js')}}
{{ HTML::script('packages/highcharts/js/modules/exporting.js')}}
{{ HTML::script('packages/highcharts/js/highcharts-more.js')}}





<div class="container">




	<ol class="breadcrumb">
  	<li><a href="#">Home</a></li>
  	<li class="active">Forecast</li>
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
			


		{{ Form::open(array('url' => 'forecast', 'method' => 'POST')) }}
	<div class="col-md-12 ">
		
				<div class="row">
				<div class="col-md-2 column">
				{{ Form::select('basin',array(''=>'') +  Riverbasin::lists('basin_name','basin_id'),null,
				array('class'=>'chosen-select','data-placeholder'=>'Select Basin','id'=>'basin','style'=>"width: 160px;"))}}
				</div>
	
				
				<div class="col-md-2 column">
				{{ Form::select('season',array(''=>''),null,
				array('class'=>'chosen-select','data-placeholder'=>'Select Season','id'=>'season','style'=>"width: 160px;"))}}
				</div>
				
	
				
				</div>
				
				<div class="row"> <br></div>
			  {{Form::submit('submit', array('class' => 'btn btn-primary btn-sm'))}}
			  <div class="row"> <br></div>
			   
			 {{ Form::close() }}
						
	</div>
				
				




	<ul class="nav nav-tabs" id="Tab_" >
	  	<li class="active"><a href="#rain" data-toggle="tab">Boxplot</a></li>
	
  		<li ><a href="#temp" data-toggle="tab">Temp</a></li>

		</ul>

		<div class="tab-content">
  				<div class="tab-pane fade in active" id="rain" >
 				<div id="container" ></div>
				</div>
				<div class="tab-pane fade " id="temp">
  				<div id="container2"  "     style="width:84.5%;"></div>
				</div>
		</div>

<script type="text/javascript">
$(function () {
    $('#container').highcharts({

        chart: {
            type: 'boxplot'
        },

        title: {
            text: 'Highcharts Box Plot Example'
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
            zoomType: 'x'
            
        },

        colors: ['#ff371c', '#0d233a', '#8bbc21', '#910000', '#1aadce', 
                 '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a'],
        title: {
            text: 'อุณหภูมิ (°C)'
        },
        subtitle: {
            text: document.ontouchstart === undefined ?
                'Click and drag in the plot area to zoom in' :
                'Pinch the chart to zoom in'
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
     

        	categories: [<?php echo $data_list?>],
        	minTickInterval: <?php echo $i/8?>                     
        	                    
    	
        
        },
        yAxis: {
            title: {
                text: 'อุณหภูมิ (°C)'
            }
        },
        

        series: [{
            type: 'line',
            name: 'mean',
            
       
            data: [<?php echo $mean_temp?>]
        }]
    });
});




$(document).ready(function(){

	$('.chosen-select').chosen();
	$('#basin').change(function(){
		var value = $("#basin").val();
		
		$.ajax({
			type:'POST',
			url:"season",
			data:{id:value},
			success:function(data){
				
				$('#season').find('option')
							  .remove()
							  .end()
							  .append(data)
							  .trigger('chosen:updated');
				
			}
		});
	});



});

		</script>
	




