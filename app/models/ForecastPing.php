<?php

class ForecastPing extends Forecast {

    private function isNDJ($se){
        if($se!="NDJ")return true; ;
        return false;
    }
    private function genNDJ($b){
        if($this->isNDJ($b)==true) return " coalesce((meas_value2,-9999), as val2";
        return "";
    }

    
    private function refExportToTextFile($basin,$season,$baseyear,$addyear) {
        
        $year=$baseyear+$addyear; 
        if($season=="NDJ") {$year = $year+1;}
        $outputfile = 'C:\\\\wamp\\\\www\\\\rain\\\\protected\\\\R\\\\'.$basin.'\\\\'.$season.'\\\\'.$season.'_predictors.txt' ; //
        $cmd =
                " select meas_year,meas_month, " .
                " coalesce(meas_value1,-9999) as val1, " .
                
                $this->genNDJ($season).
                " coalesce(meas_value3,-9999) as val3,  " .
                " coalesce(meas_value4,-9999) as val4  " .
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
       
       $textoutput = str_replace('-9999','NA',$textoutput);
       
       file_put_contents($outputfile,$textoutput);
    }

     public function forecast($Input) {
        $season2month = array(
            "ASO" =>8,
            "MJJ" => 5,
            "NDJ" => 11,
            "FMA" => 2
        );
        chdir( 'C:\\\\wamp\\www\\rain\\protected'.DIRECTORY_SEPARATOR . 'R' . DIRECTORY_SEPARATOR.'Ping'.'\\'.$Input['season'].'\\');
        exec('del *.Rdata');
        exec('del *.out');
        exec('del pingrain.txt');
        exec('del '.$Input['season'].'_predictors.txt');
        
        
        // calculate lag time
        $add_year = 0;
        $curmonth= $Input['basemonth'];// date('m', strtotime('0 month'));
        $lagtime = $season2month[$Input['season']] - $curmonth;
        if($lagtime < 0){
            $lagtime=$lagtime+12;
            $add_year = 1; // forcast next year
        }
        //echo $lagtime;
        
        
        // first gather data
        parent::refRawDataToForecast("ping",7,$Input['season']);
       $this->refExportToTextFile("ping",$Input['season'],$Input['baseyear'], $add_year);
        
        // 2nd gather rain fall 4G
        //
        parent::Exportrainfall4G("ping",7,$Input['season']);
        
        // 3rd modify parameter according to the web form
        $script_file =  $Input['season'].'.bat';
        $cmd = 'C:\\\\wamp\\www\\rain\\protected\\R\\Ping\\'.$Input['season'].'\\'.$script_file; //TODO: cross platform
        $cmdtxt = 'C:\\\\wamp\\www\\rain\\protected\\R\\Ping\\'.$Input['season'].'\\'.$Input['season'].'.txt'; //TODO: cross platform
        $file = $cmdtxt.'.org';
        file_put_contents($cmdtxt,str_replace('$$LAGTIME$$',$lagtime,file_get_contents($file)));
        
        
        // 4th execute command line
        $script_file =  $Input['season'].'.bat';
        $cmd = 'C:\\\\wamp\\www\\rain\\protected\\R\\Ping\\'.$Input['season'].'\\'.$script_file; //TODO: cross platform
        $text = shell_exec($cmd);
        
         // 5th execute SPI
        $script_file =  'spi.bat';
        $cmd = 'C:\\\\wamp\\www\\rain\\protected\\R\\Ping\\'.$Input['season'].'\\'.$script_file; //TODO: cross platform
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
        //file_put_contents(Yii::app()->basePath . DIRECTORY_SEPARATOR .'rawdata.txt', $text);   
        $Input['rawdata'] = $text;        
        }
        
        // read spi
        $outputfile = $Input['season'].$lagtime.'-mSPI.out';
         $text = file_get_contents($outputfile);
        //file_put_contents(Yii::app()->basePath . DIRECTORY_SEPARATOR .'rawdata.txt', $text); // TODO better solution  
        $Input['spi'] = $text;  
        
        return $Input;
    }
   


}

?>