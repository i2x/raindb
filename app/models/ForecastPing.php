<?php

class ForecastPing extends Forecast {

    private function isNDJ($se){
        if($se!="NDJ")return true; ;
        return false;
    }
    private function genNDJ($b){
        if($this->isNDJ($b)==true) return " coalesce(meas_value2,-999) as val2,";
        return "";
    }

    
    private function refExportToTextFile($basin,$season,$baseyear,$addyear) {
        
        $year=$baseyear+$addyear; 
        if($season=="NDJ") {$year = $year+1;}
        $outputfile = base_path().DIRECTORY_SEPARATOR.'R'.DIRECTORY_SEPARATOR.$basin.DIRECTORY_SEPARATOR.$season.DIRECTORY_SEPARATOR.'predictors.txt' ; //
        $cmd =
                " select meas_year,meas_month, " .
                " coalesce(meas_value1,-999) as val1, " .
                
                $this->genNDJ($season).
                " coalesce(meas_value3,-999) as val3,  " .
                " coalesce(meas_value4,-999) as val4  " .
                " from tbl_ref_data4forecast_".$basin." " .
                " where season ='$season' ".
                " and  (".$year." )* 100+12>= meas_year*100 + meas_month order by meas_year,meas_month"
                ;
       $results = DB::select(DB::raw($cmd));
       $textoutput = "";
       if($this->isNDJ($season)==true){
       foreach($results as $result){
           $textoutput = $textoutput. $result->meas_year . "\t" . $result->meas_month . "\t" .
                   $result->val1 . "\t" .
                   $result->val2 . "\t" .
                   $result->val3 . "\t" .
                   $result->val4 . "\n"; 
       }           
       }
       else
       {
           foreach($results as $result){
           $textoutput = $textoutput.  $result->meas_year . "\t" . $result->meas_month . "\t" .
                   $result->val1 . "\t" .                  
                   $result->val3 . "\t" .
                   $result->val4 . "\r\n" ;  
           }
       }
       
       $textoutput = str_replace('-999','NA',$textoutput);
       
       file_put_contents($outputfile,$textoutput);
    }

     public function forecast($Input) {
        $season2month = array(
            "ASO" =>8,
            "MJJ" => 5,
            "NDJ" => 11,
            "FMA" => 2
        );
        $forecastpath = base_path().DIRECTORY_SEPARATOR . 'R' . DIRECTORY_SEPARATOR.'ping'. DIRECTORY_SEPARATOR.$Input['season']. DIRECTORY_SEPARATOR;
        chdir($forecastpath );
        exec('del *.Rdata');
        exec('del *.out');
        exec('del rain.txt');
        exec('del '.$Input['season'].'_predictors.txt');
        
        
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
        parent::refRawDataToForecast("ping",7,$Input['season']);
       $this->refExportToTextFile("ping",$Input['season'],$Input['baseyear'], $add_year);
        
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
