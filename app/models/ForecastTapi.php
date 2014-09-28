<?php

class ForecastTapi extends Forecast {


        private $BASIN_NAME = "tapi";
    private $BASIN_ID = 11;
    private function refExportToTextFile($season) {
        
        //$year=$addyear; 
        $cmd =
                " select ref_setting_id,varname 
                  from tbl_ref_settings_forecast_season_basin inner join
                  tbl_ref_settings on tbl_ref_settings.idtbl_ref_settings = 
                  tbl_ref_settings_forecast_season_basin.ref_setting_id
                 where tbl_ref_settings_forecast_season_basin.season ='$season' 
                 and  tbl_ref_settings_forecast_season_basin.basin_id = $this->BASIN_ID ";
        
       $results = DB::select(DB::raw($cmd));
       
       foreach($results as $result){
        $outputfile = base_path().DIRECTORY_SEPARATOR.'R'.DIRECTORY_SEPARATOR.$this->BASIN_NAME.DIRECTORY_SEPARATOR.$season.DIRECTORY_SEPARATOR.trim($result->varname).".txt" ; //
        //Log::info($outputfile);
        $cmdr = "select rawtext from tbl_ref_data_raw where refid=$result->ref_setting_id";
           $res = DB::select(DB::raw($cmdr)); 
           foreach($res as $rs){
            file_put_contents($outputfile,$rs->rawtext);
           }
       }           
       
       
    }

    public function Exportrainfall( $select_season) {
        
        $lstyear = parent::getlatestyear($this->BASIN_ID);
        $sql = "SELECT 
     yee,
      MAX(CASE WHEN moo = '1' THEN rx ELSE NULL END) as JAN,
      MAX(CASE WHEN moo = '2' THEN rx ELSE NULL END) as FEB,
      MAX(CASE WHEN moo = '3' THEN rx ELSE NULL END) as MAR,
MAX(CASE WHEN moo = '4' THEN rx ELSE NULL END) as APR,
MAX(CASE WHEN moo = '5' THEN rx ELSE NULL END) as MAY,
MAX(CASE WHEN moo = '6' THEN rx ELSE NULL END) as JUN,
MAX(CASE WHEN moo = '6' THEN rx ELSE NULL END) as JUL,
MAX(CASE WHEN moo = '8' THEN rx ELSE NULL END) as AUG,
MAX(CASE WHEN moo = '9' THEN rx ELSE NULL END) as SEP,
MAX(CASE WHEN moo = '10' THEN rx ELSE NULL END) as OCT,
MAX(CASE WHEN moo = '11' THEN rx ELSE NULL END) as NOV,
MAX(CASE WHEN moo = '12' THEN rx ELSE NULL END) as DEC
FROM 
(
select  c.yee, c.moo, coalesce(a.r1,-9999) as rx   	
    		 from (select min(ye) as yee, min(mo) as moo from calendar_table where calendar_table.ye >= 1980 and calendar_table.ye <=$lstyear
             group by ye,mo ) c
    		 left join 
             (
              select tbl_rain_measurement.meas_year, tbl_rain_measurement.meas_month,avg(rain)*30 as r1 from 
              tbl_rain_measurement 
              inner join tbl_selected_stations 
              on tbl_selected_stations.station_id = tbl_rain_measurement.station_id
              where 
              tbl_selected_stations.basin_id = $this->BASIN_ID
              group by tbl_rain_measurement.meas_year,tbl_rain_measurement.meas_month
             ) a
             on (c.yee = a.meas_year and c.moo = a.meas_month) order by yee,moo 
)
aaa
GROUP BY yee";
     $results = DB::select(DB::raw($sql));
     $textoutput = "";
    $outputfile = base_path(). DIRECTORY_SEPARATOR ."R". DIRECTORY_SEPARATOR .$this->BASIN_NAME. DIRECTORY_SEPARATOR .$select_season. DIRECTORY_SEPARATOR ."IRF.txt" ; //
    
    if (file_exists($outputfile)){unlink($outputfile);};

       foreach($results as $result){
           $textoutput = $textoutput. 
                   $result->yee . "\t" .
                   $result->jan . "\t" .
                   $result->feb . "\t" .
                   $result->mar . "\t" .
                   $result->apr . "\t" .
                   $result->may . "\t" .
                   $result->jun . "\t" .
                   $result->jul . "\t" .
                   $result->aug . "\t" .
                   $result->sep . "\t" .
                   $result->oct . "\t" .
                   $result->nov . "\t" .
                   $result->dec . "\r\n" ; 
       }           

       
       file_put_contents($outputfile,$textoutput);       
        
    }
    
     public function forecast($Input) {

        $forecastpath = base_path().DIRECTORY_SEPARATOR . 'R' . DIRECTORY_SEPARATOR.$this->BASIN_NAME. DIRECTORY_SEPARATOR.$Input['season']. DIRECTORY_SEPARATOR;
        chdir($forecastpath );
        exec('del *.Rdata');
        
        
        // calculate lag time
        $add_year = 0;
        $curmonth= $Input['basemonth'];// date('m', strtotime('0 month'));
        $lagtime = $this->season2month($Input['season']) - $curmonth;
        if($lagtime < 0){
            $lagtime=$lagtime+12;
            $add_year = 1; // forecast next year
        }
        //echo $lagtime;
        
        
        // first gather data
       $this->refExportToTextFile($Input['season']);
        
        // 2nd gather rain fall 4G
        //
        $this->Exportrainfall($Input['season']);
        
        // 3rd modify parameter according to the web form
        //$cmdtxt = base_path().DIRECTORY_SEPARATOR.'R'.DIRECTORY_SEPARATOR.'ping'.DIRECTORY_SEPARATOR.$Input['season'].DIRECTORY_SEPARATOR.$Input['season'].'.txt'; 
        //$file = $cmdtxt.'.org';
        //file_put_contents($cmdtxt,str_replace('$$LAGTIME$$',$lagtime,file_get_contents($file)));
        //chmod($cmdtxt,0775);
        
        // 3.5 modify scrip file
        //$org_script_file = $forecastpath.'R.bat.org';   // original script file    
        $output_file = $forecastpath.'R.bat'; // unix style
        //file_put_contents($output_file,str_replace('$$path$$',$forecastpath,file_get_contents($org_script_file)));
        //chmod($output_file,0755);      
        
        // 4th execute command line
        $cmd = $output_file;
        $text = shell_exec($cmd);
        
         // 5th execute SPI
        $script_file =  'spi.bat';
        $cmd = base_path().DIRECTORY_SEPARATOR.'R'.DIRECTORY_SEPARATOR.$this->BASIN_NAME.DIRECTORY_SEPARATOR.$Input['season'].DIRECTORY_SEPARATOR.$script_file; 
        $text = shell_exec($cmd);
        
       
        // 
        // 
        // read output and display
        $outputfile = 'out.txt';
        if(!file_exists($outputfile)){
            $text = "Error occured, please check parameters and data";
            $Input['errormessage'] = $text;
            return $Input;
        } else {
        $text = file_get_contents($outputfile);        
        $Input['rawdata'] = $text;        
        }
        
        // read spi
        $outputfile = 'SPIO.txt';
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
