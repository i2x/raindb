<?php


class Forecast {

    // query raw reference data and put on another table, ready for forecasting
    public function refRawDataToForecast($basin,$basin_id,$season) {
        $cmd = "SELECT * FROM tbl_ref_settings_forecast_season_basin where basin_id = ".$basin_id." and season = '".$season."' order by columnorder";
        $rows = DB::select(DB::raw($cmd));
        foreach ($rows as $row){
           
        $cmd =
                "update tbl_ref_data4forecast_".$basin." set meas_value".$row->columnorder." = tbl_ref_data.meas_value " .
                " from tbl_ref_data where tbl_ref_data4forecast_".$basin.".season = '".$season."'  " .
                "and tbl_ref_data4forecast_".$basin.".meas_year = tbl_ref_data.meas_year " .
                "and tbl_ref_data4forecast_".$basin.".meas_month = tbl_ref_data.meas_month " .
                "and tbl_ref_data.refid = " .$row->ref_setting_id;
            DB::select(DB::raw($cmd));
        }
    }
    
   // public function forecast($Input){}
    

     private function actionRainForecastChi($model) {
        chdir(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'R' . DIRECTORY_SEPARATOR.'Chi');
        $script_file =  $model->select_season.'.bat';        
        
        exec('del *.Rdata');
        exec('del *.out');
        
        //exec('del Averg50_MJJ_GCMpreds.txt');
        //$forecast = new ForecastMun();
        // first gather data
        //$forecast->refRawDataToForecast();
        //$forecast->refExportToTextFile();
        // modify parameter according to the web form

        $cmd = 'C:\wamp\www\rain\protected\R\Chi'. DIRECTORY_SEPARATOR.$model->select_season.DIRECTORY_SEPARATOR.$script_file;
          //TODO: cross platform
        echo $cmd;
        $text = shell_exec($cmd);
        $text = file_get_contents($model->select_season.DIRECTORY_SEPARATOR."out.txt");
        $model->rawdata = $text;
file_put_contents(Yii::app()->basePath . DIRECTORY_SEPARATOR .'rawdata'.DIRECTORY_SEPARATOR.'rawdata.txt', $text);   
        $this->render('rainforecast', array('model' => $model,'basin' => 9));
    }

        private function actionRainForecastMun($model) {
        $season2month = array(
            "JFM" =>1,
            "FMA" => 2,
            "MAM" => 3,
            "AMJ" => 4,
            "MJJ" => 5,
            "JJA" =>6,
            "JAS" => 7,
            "ASO" => 8,
            "SON" => 9,
            "OND" => 10,
            "NDJ" => 11,
            "DJF" => 12
        );
        chdir(Yii::app()->basePath . DIRECTORY_SEPARATOR . 'R' . DIRECTORY_SEPARATOR.'Mun'.'\\'.$model->select_season.'\\');
        exec('del *.Rdata');
        exec('del *.out');
        exec('del munrain.txt');
        exec('del '.$model->select_season.'_predictors.txt');
        
        $forecast = new ForecastMun();
        
        // calculate lag time
        $add_year = 0;
        $curmonth= date('m', strtotime('0 month'));
        $lagtime = $season2month[$model->select_season] - $curmonth;
        if($lagtime < 0){
            $lagtime=$lagtime+12;
            $add_year = 1; // forcast next year
        }
        //echo $lagtime;
        
        
        // first gather data
        $forecast->refRawDataToForecast("mun",10,$model->select_season);
        $forecast->refExportToTextFile("mun",$model->select_season,$add_year);
        
        // 2nd gather rain fall 4G
        //
        $forecast->Exportrainfall4G("mun",10,$model->select_season);
        
        // 3rd modify parameter according to the web form
        $script_file =  $model->select_season.'.bat';
        $cmd = 'C:\\\\wamp\\www\\rain\\protected\\R\\Mun\\'.$model->select_season.'\\'.$script_file; //TODO: cross platform
        $cmdtxt = 'C:\\\\wamp\\www\\rain\\protected\\R\\Mun\\'.$model->select_season.'\\'.$model->select_season.'.txt'; //TODO: cross platform
        $file = $cmdtxt.'.org';
        file_put_contents($cmdtxt,str_replace('$$LAGTIME$$',$lagtime,file_get_contents($file)));
        
        
        // 4th execute command line
        $script_file =  $model->select_season.'.bat';
        $cmd = 'C:\\\\wamp\\www\\rain\\protected\\R\\Mun\\'.$model->select_season.'\\'.$script_file; //TODO: cross platform
        $text = shell_exec($cmd);
        
        // read output and display
        $outputfile = $model->select_season.$lagtime.'-mForecast.out';
        if(!file_exists($outputfile)){
            $text = "please update NOAA data";
            echo $text;
            unset($model->rawdata);
        } else {
        $text = file_get_contents($outputfile);
        $model->rawdata = $text;        
        }
        $this->render('rainforecast', array('model' => $model,'basin' => 10));
    }
    

       
    public function Exportrainfall4G($select_basin,$basin_id,$select_season)
    {    	    	     
        //TODO basin ID 
    //$outputfile = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'R'. DIRECTORY_SEPARATOR . 'Ping' . DIRECTORY_SEPARATOR .'rainfall4G.txt';
        $outputfile = "C:\\\\wamp\\\\www\\\\rain\\\\protected\\\\R\\\\".$select_basin."\\\\".$select_season."\\\\".$select_basin."rain.txt" ; //
    
    if (file_exists($outputfile)){unlink($outputfile);};
    //meas_year >= 1948 and meas_year <=2007 and
    $cmd = " select  c.yee, c.moo, coalesce(a.r1,-9999) as rx   	
    		 from (select min(ye) as yee, min(mo) as moo from calendar_table where calendar_table.ye >= 1948 and calendar_table.ye <=2007 
             group by ye,mo ) c
    		 left join 
             (
              select tbl_rain_measurement.meas_year, tbl_rain_measurement.meas_month,SUM(rain) as r1 from 
              tbl_rain_measurement 
              inner join tbl_selected_stations 
              on tbl_selected_stations.station_id = tbl_rain_measurement.station_id
              where 
              tbl_selected_stations.basin_id = ".$basin_id."
              group by tbl_rain_measurement.meas_year,tbl_rain_measurement.meas_month
             ) a
             on (c.yee = a.meas_year and c.moo = a.meas_month) order by yee,moo ";

     $results = DB::select(DB::raw($cmd));
     $textoutput = "";

       foreach($results as $result){
           $textoutput = $textoutput. $result->yee . "\t" . $result->moo . "\t" .
                   $result->rx . "\r\n" ; 
       }           

       $textoutput = str_replace('-9999','NA',$textoutput);
       
       file_put_contents($outputfile,$textoutput);       
    }
    
    
   public function getlatestyear($basin_id)
   {
   	 $sql = "select date_part('year',max(meas_date)) as yy from tbl_rain_measurement inner join 
			tbl_selected_stations on tbl_selected_stations.station_id = tbl_rain_measurement.station_id 
			where basin_id = ".$basin_id;
   	 
   	         $_lastyear = DB::select(DB::raw($sql));
   	         return $_lastyear[0]->yy;
   	      
   }
   
   
   function extract_raw_data($rawdata){
   // extract raw data 300 values from text
    $temp = preg_split("/[\s,]+/", rawdata);
    $start = sizeof($temp)-300;
    for($i=$start;$i<sizeof($temp)-1;$i++)
    {
    	    $data[$i] = (float)$temp[$i];
    	
    }
    return $data;
   }
   
   function gen_box_plot_data($data){
       return array(min($data), $this->stats_stat_percentile ($data ,25   ),
    		 $this->array_median($data), $this->stats_stat_percentile ($data ,75 ),
              max($data));
   }
   
function stats_stat_percentile($data,$percentile){ 
    if( 0 < $percentile && $percentile < 1 ) { 
        $p = $percentile; 
    }else if( 1 < $percentile && $percentile <= 100 ) { 
        $p = $percentile * .01; 
    }else { 
        return ""; 
    } 
    $count = count($data); 
    $allindex = ($count-1)*$p; 
    $intvalindex = intval($allindex); 
    $floatval = $allindex - $intvalindex; 
    sort($data); 
    if(!is_float($floatval)){ 
        $result = $data[$intvalindex]; 
    }else { 
        if($count > $intvalindex+1) 
            $result = $floatval*($data[$intvalindex+1] - $data[$intvalindex]) + $data[$intvalindex];
        else 
            $result = $data[$intvalindex]; 
    } 
    return $result; 
} 



function array_median($array) {
	// perhaps all non numeric  should filtered out of $array here?
	$iCount = count($array);
	if ($iCount == 0) {
		throw new DomainException('Median of an empty array is undefined');
	}
	// if we're down here it must mean $array
	// has at least 1 item in the array.
	$middle_index = floor($iCount / 2);
	sort($array, SORT_NUMERIC);
	$median = $array[$middle_index]; // assume an odd # of items
	// Handle the even case by averaging the middle 2 items
	if ($iCount % 2 == 0) {
		$median = ($median + $array[$middle_index - 1]) / 2;
	}
	return $median;
}
function classify($data,$step)
{
	$result = array(0,0,0,0,0,0,0,0,0,0,0,0);
	
	
	foreach ($data as $value)
	{
	if($step[0] <= $value  && $step[1] > $value)
	{
		$result[0]++;
	}
	if($step[1] <= $value  && $step[2] > $value)
	{
		$result[1]++;
	}
	if($step[2] <= $value  && $step[3] > $value)
	{
		$result[2]++;
	}
	if($step[3] <= $value  && $step[4] > $value)
	{
		$result[3]++;
	}
	if($step[4] <= $value  && $step[5] > $value)
	{
		$result[4]++;
	}
	if($step[5] <= $value  && $step[6] > $value)
	{
		$result[5]++;
	}
	if($step[6] <= $value  && $step[7] > $value)
	{
		$result[6]++;
	}
	if($step[7] <= $value  && $step[8] > $value)
	{
		$result[7]++;
	}
	if($step[8] <= $value && $step[9] > $value)
	{
		$result[8]++;
	}
	if($step[9] <= $value  && $step[10] > $value)
	{
		$result[9]++;
	}
	if($step[10] <= $value && $step[11] > $value)
	{
		$result[10]++;
	}
		
	}
	
	
	return $result;
	
}

 function probability33_67($data)
{
	$upper = stats_stat_percentile($data,67);
	$lowwer = stats_stat_percentile($data,33);
	$temp = array();
	$temp['Above-normal'] = 0;
	$temp['Normal'] = 0;
	$temp['Below-normal'] = 0;
	foreach ($data as $value)
	{
		if($upper < $value)
		{
			$temp['Above-normal']++;
		}
		else if($upper >= $value && $lowwer <= $value )
		{
			$temp['Normal']++;
		}
		elseif ($lowwer > $value )
		{
			$temp['Below-normal']++;
		}
	}

	$temp['Above-normal'] = (float)number_format($temp['Above-normal']/3, 2, '.', '');
	$temp['Normal']       = (float)number_format($temp['Normal']/3, 2, '.', '');
	$temp['Below-normal'] = (float)number_format($temp['Below-normal']/3, 2, '.', '');
	
	
	return $temp;
	
}


function probability20_80($data)
{
	$upper = stats_stat_percentile($data,80);
	$lowwer = stats_stat_percentile($data,20);
	$temp = array();
	$temp['Above-normal'] = 0;
	$temp['Normal'] = 0;
	$temp['Below-normal'] = 0;
	foreach ($data as $value)
	{
		if($upper < $value)
		{
			$temp['Above-normal']++;
		}
		else if($upper >= $value && $lowwer <= $value )
		{
			$temp['Normal']++;
		}
		elseif ($lowwer > $value )
		{
			$temp['Below-normal']++;
		}
	}

	$temp['Above-normal'] = (float)number_format($temp['Above-normal']/3, 2, '.', '');
	$temp['Normal']       = (float)number_format($temp['Normal']/3, 2, '.', '');
	$temp['Below-normal'] = (float)number_format($temp['Below-normal']/3, 2, '.', '');


	return $temp;

}

function SPI($data)
{
	


	
	$temp = array(0,0,0,0,0,0,0);
	
	//$path = Yii::app()->basePath . DIRECTORY_SEPARATOR . 'R' .DIRECTORY_SEPARATOR .'Chi'. DIRECTORY_SEPARATOR .'AMJ'. DIRECTORY_SEPARATOR .'outspi.txt';
	//$text = file($path);
        $text = $data;
	foreach ($text as $value)
	{
		//echo $value."<br/>";
		//$value = ($value % 8 ) - 4 ;//  Shifting and Scaling for fake data
		
	
		if((float)$value <= (-2.0))
		{
			$temp[0]++;
		}
		else if((-2.0) > (float)$value && (float)$value <= (-1.5))
		{
			$temp[1]++;
				
		}
		else if((-1.5) > (float)$value && (float)$value <= (-1.0))
				{
			$temp[2]++;
				
		}
		else if((-1.0) > (float)$value && (float)$value <= (1.0))
				{
			$temp[3]++;
				
		}
		else if((1.0) > (float)$value && (float)$value <= (1.5))
				{
			$temp[4]++;
				
		}
		else if((1.5) > (float)$value && (float)$value <= (2.0))
				{
			$temp[5]++;
				
		}
		else 
		{
			$temp[6]++;
				
		}
		
	
		
		
	}
	foreach ($temp as $key => $value)
	{
		$temp[$key] = (float)number_format($value/3, 2, '.', '');
		
	}
	return $temp;//array_reverse($temp);
	
}
   

}

?>
