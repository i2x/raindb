<title>Rain - Forecast</title>
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
    $data = HistoricData::select(array('mean_temp', 'meas_date', 'rain'))->limit(360)->get();
    $graph = ' ';
    $mean_temp = ' ';
    $data_list = ' ';
    for ($i = 0; $i < sizeof($data); $i++) {

        $yrdata = strtotime(($data[$i]['meas_date']));
        if ($i == 0) {
            $graph = $graph . $data[$i]['rain'];
            $mean_temp = $mean_temp . $data[$i]['mean_temp'];
            $data_list = $data_list . '"' . date('d M Y', $yrdata) . '"';
        } else {
            $graph = $graph . ',' . $data[$i]['rain'];
            $mean_temp = $mean_temp . ',' . $data[$i]['mean_temp'];
            $data_list = $data_list . ',"' . date('d M Y', $yrdata) . '"';
        }
    }
    ?>



    {{ Form::open(array('url' => 'forecast', 'method' => 'POST')) }}
    <div class="col-md-12 ">

        <div class="row">
            <div class="col-md-2 column">
                Basin:
                @if (isset($oldInput))
                {{ Form::select('basin',array(''=>'') +  Riverbasin::lists('basin_name','basin_id'),$oldInput['basin'],
                array('class'=>'chosen-select','data-placeholder'=>'Select Basin','id'=>'basin','style'=>"width: 160px;"))}}
                @else
                {{ Form::select('basin',array(''=>'') +  Riverbasin::lists('basin_name','basin_id'),null,
                array('class'=>'chosen-select','data-placeholder'=>'Select Basin','id'=>'basin','style'=>"width: 160px;"))}}
                @endif
            </div>


            <div class="col-md-2 column">
                Season:
                 @if (isset($oldInput) )
                 @if ($oldInput['basin']==7)
                {{ Form::select('season',array(''=>'','FMA'=>'FMA','MJJ'=>'MJJ','ASO'=>'ASO','NDJ'=>'NDJ'),$oldInput['season'],
                array('class'=>'chosen-select','data-placeholder'=>'Select Season','id'=>'season','style'=>"width: 160px;"))}}
                @else
                {{ Form::select('season',array(''=>'')+Season::lists('season','season'),$oldInput['season'],
                array('class'=>'chosen-select','data-placeholder'=>'Select Season','id'=>'season','style'=>"width: 160px;"))}}
                
                @endif
                @else
                {{ Form::select('season',array(''=>'')+Season::lists('season','season'),null,
                array('class'=>'chosen-select','data-placeholder'=>'Select Season','id'=>'season','style'=>"width: 160px;"))}}
                @endif
            </div>

            <div class="col-md-2 column">
                <?php
                if (isset($oldInput))
                    $selected_year = $oldInput['baseyear'];
                else
                    $selected_year = date("Y");                
                ?>
                Reference Year:
                {{ Form::select('baseyear',array(''=>'') +  Year::lists('year','year'),$selected_year,
                array('class'=>'chosen-select','data-placeholder'=>'Select Reference Year','id'=>'baseyear','style'=>"width: 160px;"))}}
            </div>

            <?php
   $lmonth= array(1=>'JAN',2=>'FEB',3=>'MAR',4=>'APR',5=>'MAY',6=>'JUN',7=>'JUL',8=>'AUG',9=>'SEP',10=>'OCT',11=>'NOV',12=>'DEC');
                if(!isset($oldInput['baseyear'])){$baseyear = date("Y");}else
                    $baseyear = $oldInput['baseyear'];
                if( $baseyear == date("Y")){
                    $mto = date("m")-2;
                } else {
    			$mto=12;
                }
                
                      $mdata = array();
    			for($i=1;$i<=$mto ;$i++){
                            $mdata[$i]= $lmonth[$i];
                        }
                
                //if(!isset($oldInput['basemonth'])){$moption = array('options' => array($i-1=>array('selected'=>true)));}
                //else {$moption = array();}
                //echo $form->dropDownList($model,'basemonth',$mdata, $moption);
             
            ?>
            <div class="col-md-2 column">
                <?php
                if (isset($oldInput))
                    $selected_month = $oldInput['basemonth'];
                else
                    $selected_month = $mto;                
                ?>
                Reference Month:
                {{ Form::select('basemonth',array(''=>'') + $mdata ,$selected_month,
                array('class'=>'chosen-select','data-placeholder'=>'Month','id'=>'basemonth','style'=>"width: 160px;"))}}
            </div>
            

        </div>

        <div class="row"> <br></div>
        {{Form::submit('submit', array('class' => 'btn btn-primary btn-sm'))}}
        <div class="row"> <br></div>

        {{ Form::close() }}

    </div>
@if (isset($oldInput) && isset($rawdata))
    <div>
        Forecast Info:<br/>
Basin: {{Riverbasin::where('basin_id', '=',$oldInput['basin'] )->firstOrFail()->basin_name}} <br/>
Forecast for: Month {{$oldInput['season']}} Year {{$targetyear}} <br/>
Reference Date Range: 1980-{{$baseyear}} </br>
Rain Data Date Range: 1980-{{$rainyear}} </br>
    </div>
<br/>



    <ul class="nav nav-tabs" id="Tab_" >
        <li class="active"><a href="#boxp" data-toggle="tab">Boxplot</a></li>

        <li ><a href="#p33" data-toggle="tab">P33/66</a></li>
        <li ><a href="#p20" data-toggle="tab">P20/80</a></li>
        <li ><a href="#spi" data-toggle="tab">SPI</a></li>
        <li ><a href="#rawdata" data-toggle="tab">Raw Data</a></li>

    </ul>

    <div class="tab-content">
        <div class="tab-pane fade in active" id="boxp" >
            <div id="container" ></div>
        </div>
        <div class="tab-pane fade " id="p33">
            <div id="container2" ></div>
        </div>
        <div class="tab-pane fade " id="p20">
            <div id="container3" ></div>
        </div>
                <div class="tab-pane fade " id="spi">
            <div id="container4" ></div>
        </div>
                        <div class="tab-pane fade " id="rawdata">
  Raw Data Output:
<div>
    {{$rawdata}}
</div>
SPI Output:
<div>
    {{$spi}}
</div>           
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#container').highcharts({
                chart: {
                    type: 'boxplot',
                    zoomType: 'x',
                    width: 200

                },
                title: {
                    text: 'Rain'
                },
                legend: {
                    enabled: false
                },
                xAxis: {
                    categories: [''],
                    title: {
                        text: 'Rain'
                    }
                },
                yAxis: {
                    title: {
                        text: 'mm'
                    }
                },
                series: [{
                        name: 'Observations',
                        data: [
                            [{{ implode(',',$boxplotdata) }}]
                        ],
                        tooltip: {
                            headerFormat: '<em>Rain {point.key}</em><br/>'
                        }
                    }]

            });
        });



        $(function() {


            $('#container2').highcharts({
                chart: {
                    type: 'bar',             
                    zoomType: 'x'

                },
                colors: ['#febe58','#00a4fe','#fe00fe'],
                title: {
                    text: 'Probability of Rain Fall'
                },
                subtitle: {
                    text: document.ontouchstart === undefined ?
                            'Click and drag in the plot area to zoom in' :
                            'Pinch the chart to zoom in'
                },
                tooltip: {
                    valueSuffix: ''
                },
                plotOptions: {
                    animation: false,
                },
                xAxis: {
                    type: 'category',
                    categories: ['Rain Level']
                },
                yAxis: {
                    title: {
                        text: 'Probability'
                    }
                },
                               legend: {
            align: 'right',
            verticalAlign: 'top',
            layout: 'vertical',
            x: 0,
            y: 0
        }
                 ,
                series: [{
                        type: 'bar',
                        name: 'Below-normal',
                        data: [{{$p33['Below-normal']}}]
                    },
                    {
                        type: 'bar',
                        name: 'Normal',
                        data: [{{$p33['Normal']}}]
                    },
                    {
                        type: 'bar',
                        name: 'Above-normal',
                        data: [{{$p33['Above-normal']}}]
                    }
                ]
            });
        });


        $(function() {


            $('#container3').highcharts({
                chart: {
                    type: 'bar',             
                    zoomType: 'x'

                },
                colors: ['#febe58','#00a4fe','#fe00fe'],
                title: {
                    text: 'Probability of Rain Fall'
                },
                subtitle: {
                    text: document.ontouchstart === undefined ?
                            'Click and drag in the plot area to zoom in' :
                            'Pinch the chart to zoom in'
                },
                tooltip: {
                    valueSuffix: ''
                },
                plotOptions: {
                    animation: false,
                },
                xAxis: {
                    type: 'category',
                    categories: ['Rain Level']
                },
                yAxis: {
                    title: {
                        text: 'Probability'
                    }
                },
                               legend: {
            align: 'right',
            verticalAlign: 'top',
            layout: 'vertical',
            x: 0,
            y: 0
        }
                 ,
                series: [{
                        type: 'bar',
                        name: 'Below-normal',
                        data: [{{$p20['Below-normal']}}]
                    },
                    {
                        type: 'bar',
                        name: 'Normal',
                        data: [{{$p20['Normal']}}]
                    },
                    {
                        type: 'bar',
                        name: 'Above-normal',
                        data: [{{$p20['Above-normal']}}]
                    }
                ]
            });
        });


                $(function() {


            $('#container4').highcharts({
                chart: {
                    type: 'bar',             
                    zoomType: 'x'

                },
                colors: ['#bbbbbb','#febe58','#feac00','#fefe00','#b2fe00',
    		'#4cfe00','#00e499','#00a4fe','#3e3efe','#b200fe', '#fe00fe','#fe4c9b'],
                title: {
                    text: 'SPI'
                },
                subtitle: {
                    text: document.ontouchstart === undefined ?
                            'Click and drag in the plot area to zoom in' :
                            'Pinch the chart to zoom in'
                },
                tooltip: {
                    valueSuffix: ''
                },
                plotOptions: {
                    animation: false,
                },
                xAxis: {
                    type: 'category',
                    categories: ['Rain Level']
                },
                yAxis: {
                    title: {
                        text: 'Probability'
                    }
                },
                               legend: {
            align: 'right',
            verticalAlign: 'top',
              layout: 'vertical',
            x:-20,
            floating: true
        }
                 ,
                series: [{
                        type: 'bar',
                        name: 'Extremely Dry',
                        data: [{{$dataISP[0]}}]
                    },
                    {
                        type: 'bar',
                        name: 'Very Dry',
                        data: [{{$dataISP[1]}}]
                    },
                    {
                        type: 'bar',
                        name: 'Moderately Dry',
                        data: [{{$dataISP[2]}}]
                    },
                    {
                        type: 'bar',
                        name: 'Near Normal',
                        data: [{{$dataISP[3]}}]
                    },
                    {
                        type: 'bar',
                        name: 'Moderately Wet',
                        data: [{{$dataISP[4]}}]
                    }
                    ,
                    {
                        type: 'bar',
                        name: 'Very Wet',
                        data: [{{$dataISP[5]}}]
                    }
                    ,
                    {
                        type: 'bar',
                        name: 'Extremely Wet',
                        data: [{{$dataISP[6]}}]
                    }
                ]
            });
        });


 </script>
 


 @endif
 <script type="text/javascript">


        $(document).ready(function() {

            $('.chosen-select').chosen();
            $('#basin').change(function() {
                var value = $("#basin").val();

                $.ajax({
                    type: 'POST',
                    url: "season",
                    data: {id: value},
                    success: function(data) {

                        $('#season').find('option')
                                .remove()
                                .end()
                                .append(data)
                                .trigger('chosen:updated');

                    }
                });
            });



        });
        
        $(document).ready(function() {

            $('.chosen-select').chosen();
            $('#baseyear').change(function() {
                var value = $("#baseyear").val();

                $.ajax({
                    type: 'POST',
                    url: "basemonth",
                    data: {baseyear: value},
                    success: function(data) {

                        $('#basemonth').find('option')
                                .remove()
                                .end()
                                .append(data)
                                .trigger('chosen:updated');

                    }
                });
            });



        });        

    </script>





