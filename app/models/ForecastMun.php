<?php

class ForecastMun extends Forecast {

    private $BASIN_NAME = "mun";
    private $BASIN_ID = 10;

    public function updateRainToPredictor(){
        
       $cmd = "
        update tbl_rainsum set rain = ccc.rx 
from (
select  10 as basin_id, c.yee, c.moo, coalesce(a.r1,-9999) as rx   	
    		 from (select min(ye) as yee, min(mo) as moo from calendar_table where calendar_table.ye >= 1948  
             group by ye,mo ) c
    		 left join 
             (
              select tbl_rain_measurement.meas_year, tbl_rain_measurement.meas_month,AVG(rain)*30 as r1 from 
              tbl_rain_measurement 
              inner join tbl_selected_stations 
              on tbl_selected_stations.station_id = tbl_rain_measurement.station_id
              where 
              tbl_selected_stations.basin_id = 10
              group by tbl_rain_measurement.meas_year,tbl_rain_measurement.meas_month             ) a
             on (c.yee = a.meas_year and c.moo = a.meas_month) order by yee,moo 
) ccc where ccc.yee = tbl_rainsum.ye and tbl_rainsum.mo = ccc.moo and ccc.basin_id = tbl_rainsum.basin_id";

                
    DB::select(DB::raw($cmd));     
        
    }
    public function refExportToTextFile($basin, $season, $baseyear,$addyear) {
        $year=$baseyear+$addyear; 
        $outputfile = base_path() .DIRECTORY_SEPARATOR. 'R' .DIRECTORY_SEPARATOR. $basin . DIRECTORY_SEPARATOR . $season . DIRECTORY_SEPARATOR .'predictors.txt'; //
        $cmd =
                " select meas_year,meas_month, " .
                " coalesce(meas_value1,-9999) as val1, " .
                " coalesce(meas_value2,-9999) as val2, "  .
                " coalesce(meas_value3,-9999) as val3, "  .
                " coalesce(meas_value4,-9999) as val4, "  .
               " coalesce(meas_value5,-9999) as val5 "  .
                " from tbl_ref_data4forecast_" . $basin . " " .
                " where season ='$season' " .
                " and  (".$year." )* 100+12>= meas_year*100 + meas_month order by meas_year,meas_month"
        ;
       $results = DB::select(DB::raw($cmd));
       $textoutput = "";
       foreach($results as $result){
           $textoutput = $textoutput. $result->meas_year . "\t" . $result->meas_month . "\t" .
                   $result->val1 . "\t" .
                   $result->val2 . "\t" .
                   $result->val3 . "\t" .
                   $result->val4 . "\t". 
                   $result->val5 . "\n"; 

           }           
       
       $textoutput = str_replace('-9999','NA',$textoutput);
       
       file_put_contents($outputfile,$textoutput);
    }


    public function forecast($Input) {
        $forecastpath = base_path().DIRECTORY_SEPARATOR . 'R' . DIRECTORY_SEPARATOR.'mun'. DIRECTORY_SEPARATOR.$Input['season']. DIRECTORY_SEPARATOR;
        chdir($forecastpath);
        exec('del *.Rdata');
        exec('del *.out');
        exec('del rain.txt');
        exec('del predictors.txt');

        // calculate lag time
        $add_year = 0;
        $curmonth = $Input['basemonth']; 
        $lagtime = $this->season2month($Input['season']) - $curmonth;
        if ($lagtime <= 0) {
            $lagtime = $lagtime + 12;
            $add_year = 1; // forecast next year
        }
        //echo $lagtime;
        // first gather data
        $this->updateRainToPredictor();
        parent::refRawDataToForecast($this->BASIN_NAME, $this->BASIN_ID, $Input['season']);
        $this->refExportToTextFile($this->BASIN_NAME, $Input['season'], $Input['baseyear'], $add_year);

        // 2nd gather rain fall 4G
        //
        parent::Exportrainfall4G($this->BASIN_NAME, $this->BASIN_ID, $Input['season']);

        // 3rd modify parameter according to the web form
       
               
        // 3rd modify parameter according to the web form
        $cmdtxt = base_path().DIRECTORY_SEPARATOR.'R'.DIRECTORY_SEPARATOR.'mun'.DIRECTORY_SEPARATOR.$Input['season'].DIRECTORY_SEPARATOR.$Input['season'].'.txt'; 
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
        $cmd = base_path().DIRECTORY_SEPARATOR.'R'.DIRECTORY_SEPARATOR.'mun'.DIRECTORY_SEPARATOR.$Input['season'].DIRECTORY_SEPARATOR.$script_file; 
        $text = shell_exec($cmd);
        
       
        // 
        // 
        // read output and display
        $outputfile = $Input['season'].$lagtime.'-mForecast.out';
        if(!file_exists($outputfile)){
            $text = "Error occured, please check parameters and data";
            $Input['errormessage'] = $text;
            return $Input;
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
