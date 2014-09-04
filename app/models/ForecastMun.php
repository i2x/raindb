<?php

class ForecastMun extends Forecast {

    public function refExportToTextFile($basin,$season,$year) {
        $outputfile = base_path().'\\\\R\\\\'.$basin.'\\\\'.$season.'\\\\'.$season.'_predictors.txt' ; //
        $cmd =
                " select meas_year,meas_month, " .
                " ifnull(meas_value1,'NA'), " .
                
                " ifnull(meas_value2,'NA'), " .
                " ifnull(meas_value3,'NA'), " .
                " ifnull(meas_value4,'NA'),   " .
                " ifnull(meas_value5,'0')   " .
                " INTO OUTFILE '".
                $outputfile
                ."' " .
                " FIELDS TERMINATED BY '\t'  " .
                " LINES TERMINATED BY '\r\n' " .
                " from tbl_ref_data4forecast_".$basin." " .
                " where season ='$season' ".
                " and  (YEAR(NOW())+".$year." )* 100+12>= meas_year*100 + meas_month "
                ;
        Yii::app()->db->createCommand($cmd)->execute();

    }
    

}

?>
