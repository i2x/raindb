<?php

class ForecastChi extends Forecast {


        private $BASIN_NAME = "mun";
    private $BASIN_ID = 9;
    private function refExportToTextFile($season) {
        
        $year=$baseyear+$addyear; 
        $cmd =
                " select ref_setting_id,varname 
                  from tbl_ref_settings_forecast_season_basin inner join
                  tbl_ref_settings on tbl_ref_settings.idtbl_ref_settings = 
                  tbl_ref_settings_forecast_season_basin.ref_setting_id
                 where tbl_ref_settings_forecast_season_basin.season ='$season' 
                 and  tbl_ref_settings_forecast_season_basin.basin_id = $this->BASIN_ID ";
        
       $results = DB::select(DB::raw($cmd));
       
       foreach($results as $result){
        $outputfile = base_path().DIRECTORY_SEPARATOR.'R'.DIRECTORY_SEPARATOR.$this->BASIN_NAME.DIRECTORY_SEPARATOR.$season.DIRECTORY_SEPARATOR."I$result->varname.txt" ; //
           file_put_contents($outputfile,$result->rawtext);
       }           
       
       
    }

     public function forecast($Input) {
        $season2month = array(
            "ASO" =>8,
            "MJJ" => 5,
            "NDJ" => 11,
            "FMA" => 2
        );
        $forecastpath = base_path().DIRECTORY_SEPARATOR . 'R' . DIRECTORY_SEPARATOR.$this->BASIN_NAME. DIRECTORY_SEPARATOR.$Input['season']. DIRECTORY_SEPARATOR;
        chdir($forecastpath );
        exec('del *.Rdata');
        
        
        // calculate lag time
        $add_year = 0;
        $curmonth= $Input['basemonth'];// date('m', strtotime('0 month'));
        $lagtime = $season2month[$Input['season']] - $curmonth;
        if($lagtime < 0){
            $lagtime=$lagtime+12;
            $add_year = 1; // forecast next year
        }
        //echo $lagtime;
        
        
        // first gather data
       $this->refExportToTextFile($Input['season'],$Input['baseyear'], $add_year);
        
        // 2nd gather rain fall 4G
        //
        parent::Exportrainfall4G("ping",7,$Input['season']);
        
        // 3rd modify parameter according to the web form
        $cmdtxt = base_path().DIRECTORY_SEPARATOR.'R'.DIRECTORY_SEPARATOR.'ping'.DIRECTORY_SEPARATOR.$Input['season'].DIRECTORY_SEPARATOR.$Input['season'].'.txt'; 
        $file = $cmdtxt.'.org';
        file_put_contents($cmdtxt,str_replace('$$LAGTIME$$',$lagtime,file_get_contents($file)));
        //chmod($cmdtxt,0775);
        
        // 3.5 modify scrip file
        $org_script_file = $forecastpath.'R.bat.org';   // original script file    
        $output_file = $forecastpath.'R.bat'; // unix style
        file_put_contents($output_file,str_replace('$$path$$',$forecastpath,file_get_contents($org_script_file)));
        chmod($output_file,0755);      
        
        // 4th execute command line
        $cmd = $output_file;
        $text = shell_exec($cmd);
        
         // 5th execute SPI
        $script_file =  'spi.bat';
        $cmd = base_path().DIRECTORY_SEPARATOR.'R'.DIRECTORY_SEPARATOR.'ping'.DIRECTORY_SEPARATOR.$Input['season'].DIRECTORY_SEPARATOR.$script_file; 
        $text = shell_exec($cmd);
        
       
        // 
        // 
        // read output and display
        $outputfile = $Input['season'].$lagtime.'-mForecast.out';
        if(!file_exists($outputfile)){
            $text = "please update NOAA data";
            echo $text;
        } else {
        $text = file_get_contents($outputfile);        
        $Input['rawdata'] = $text;        
        }
        
        // read spi
        $outputfile = $Input['season'].$lagtime.'-mSPI.out';
         $text = file_get_contents($outputfile);
        //file_put_contents(Yii::app()->basePath . DIRECTORY_SEPARATOR .'rawdata.txt', $text); // TODO better solution  
        $Input['spi'] = $text;
        
        
        // generate graph data 300 value
        $data300 = $this->extract_raw_data( $Input['rawdata']);
        // boxplot
        $boxplotdata = $this->gen_box_plot_data($data300);
        $Input['boxplotdata'] = $boxplotdata;
        
   
 
    // p33
    $data63 = $this->probability33_67($data300);
    
    $Input['p33'] = $data63;
    
    //p20
    $data82 = $this->probability20_80($data300);
$Input['p20'] = $data82;
     // spi
    $tempspi = preg_split("/[\s,]+/",  $Input['spi'] );
    $startspi = sizeof($tempspi)-300;
    for($i=$startspi;$i<sizeof($tempspi)-1;$i++)
    {
    	    $dataspi[$i] = (float)$tempspi[$i];
    	
    }
    
    
    
    $dataISP = $this->SPI($dataspi);


        
        
        
        
        $Input['dataISP']=$dataISP;
        
        return $Input;
    }
   


}

?>
