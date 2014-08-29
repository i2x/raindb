<?php


class Forecast {

    // query raw reference data and put on another table, ready for forecasting
    public function refRawDataToForecast($basin,$basin_id,$season) {
        $cmd = "SELECT * FROM tbl_ref_settings_forecast_season_basin where basin_id = ".$basin_id." and season = '".$season."' order by columnorder";
        $rows = DB::select(DB::raw($cmd));
        foreach ($rows as $row){
           
        $cmd =
                "update tbl_ref_data4forecast_".$basin.",tbl_ref_data set meas_value".$row["columnorder"]." = tbl_ref_data.meas_value " .
                "where tbl_ref_data4forecast_".$basin.".season = '".$season."'  " .
                "and tbl_ref_data4forecast_".$basin.".meas_year = tbl_ref_data.meas_year " .
                "and tbl_ref_data4forecast_".$basin.".meas_month = tbl_ref_data.meas_month " .
                "and tbl_ref_data.refid = " .$row["ref_setting_id"];
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
    $sql = " select  c.yee, c.moo, ifnull(a.r1,'NA')
    		 INTO OUTFILE '".$outputfile."' FIELDS TERMINATED BY '\t' LINES TERMINATED BY '\r\n'
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
             on (c.yee = a.meas_year and c.moo = a.meas_month)";

             Yii::app()->db->createCommand($sql)->execute();
    }
    
    
   public function getlastestyear($basin_id)
   {
   	 $sql = "select year(max(meas_date)) as yy from tbl_rain_measurement inner join 
			tbl_selected_stations on tbl_selected_stations.station_id = tbl_rain_measurement.station_id 
			where basin_id = ".$basin_id;
   	 
   	         $_lastyear = Yii::app()->db->createCommand($sql)->queryAll();
   	         return $_lastyear[0]['yy'];
   	      
   }

}

?>
