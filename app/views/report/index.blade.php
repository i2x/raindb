<title>Rain - Report</title>
{{View::make('master')}}

{{ HTML::script('packages/jquery/jquery.min.js'); }}
{{ HTML::style('packages/chosen/chosen.min.css')}}
{{ HTML::script('packages/chosen/chosen.jquery.min.js')}}
{{ HTML::script('packages/highcharts/js/highcharts.js')}}
{{ HTML::script('packages/highcharts/js/modules/exporting.js')}}



<div class="container">



<?php 

$_week = '';
$_weeksum = '';
$_weekavg = '';
$_weekmin = '';
$_weekmax = '';
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
	

	<ul class="nav nav-tabs" id="Tab_" >
	  	<li class="active"><a href="#rain" data-toggle="tab">Weekly</a></li>
	
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
@endif

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column',
            zoomType: 'x'
                
        },
        title: {
            text: 'Monthly Average Rainfall'
        },
        subtitle: {
            text: 'Source: WorldClimate.com'
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
            name: 'Sum',
            data: [<?php echo substr($_weeksum,1) ?>]

        }, 

        {
            name: 'Max',
            data: [<?php echo substr($_weekmax,1) ?>]
            

        },


        ]
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
	



