<?php

class ScheduleController extends BaseController {

    public function getIndex() {


        $file = scandir(base_path() . DIRECTORY_SEPARATOR . 'schedule');
        $temp = array();
        if (isset($file[2])) {
            for ($i = 2; $i < sizeof($file); $i++) {
                array_push($temp, array('id' => $i - 1, 'file_name' => $file[$i]));
                
            }
            
        }





            return View::make('schedule.schedule')->with('files', $temp);
        }


        

        function postIndex() {
            //TODO
            $this->actionUpdate();
		
		return $this->getIndex();
        }
        
public function actionUpdate()
	{
		
		$update = 'Update';
		//$this->Moveto_upload_file();
		
		$files = $this->FileList();
		$path = '';
		foreach ($files as $file)
		{
			
			$path = base_path() . DIRECTORY_SEPARATOR . 'schedule'.DIRECTORY_SEPARATOR.$file;
			
			if(substr($file,-3) == "xls")
			{
				
				$this->_excel($path);$type = ".xls";
				$this->Moveto_upload_file($file,$type);
				
				
				
			}
			elseif (substr($file,-3) == "txt")
			{
				$this->_text($path);$type = ".txt";
				$this->Moveto_upload_file($file,$type);
				
				
				
			}
			else 
			{
				
			}
			
			
			
		}
		
		
		
		$from = base_path() . DIRECTORY_SEPARATOR . 'schedule'.DIRECTORY_SEPARATOR;
		
	    $this->render('schedule',array('update' => $update,'temp' => $path));
				
	}
	public function FileList()
	{
		$file =  scandir(base_path() . DIRECTORY_SEPARATOR . 'schedule');
		$temp = array();
		
		if(isset($file[2]))
		{
			for ($i = 2;$i<sizeof($file);$i++)
			{
				 $temp[$i-2] = $file[$i];
		
			}
		}
		
		return $temp;
	}
	
	
	public function Moveto_upload_file($file,$type)
	{
		
		
		$new_name = $file; 
		
		if(array_search($file, scandir(base_path() . DIRECTORY_SEPARATOR . 'upload_file')))
		{
		
		$new_name =substr($file,0,-4).date('Y-m-d His').$type;
	
		
		}
		
		$from = base_path() . DIRECTORY_SEPARATOR . 'schedule'.DIRECTORY_SEPARATOR;
	    $to   = base_path() . DIRECTORY_SEPARATOR . 'upload_file'.DIRECTORY_SEPARATOR;
	    

	    $sql = "INSERT INTO `rain`.`tbl_import_log` ( `importdate`, `filename`, `detail`)
                			VALUES ( CURRENT_TIMESTAMP, '".$new_name."','update from schedule');";
	    DB:table('tbl_import_log')->insert(
                    array(
                        importdate
                    )
                    );
	
		$success = rename($from.$file, $to.$new_name);
				
	}
	

	
	public function _excel($path){
		
		
			$objPHPExcel = PHPExcel_IOFactory::load($path);
		
			$worksheet = $objPHPExcel->getActiveSheet();
			$highestRow = $worksheet->getHighestRow() . '<br>';
			for ($row = 2; $row <= $highestRow; ++$row) {
				$cell = $worksheet->getCellByColumnAndRow(1, $row);
				$sta_id = $cell->getValue();
				$cell = $worksheet->getCellByColumnAndRow(2, $row);
				$dyear = $cell->getValue();
				$cell = $worksheet->getCellByColumnAndRow(3, $row);
				$dmonth = $cell->getValue();
				$cell = $worksheet->getCellByColumnAndRow(4, $row);
				$dday = $cell->getValue();
				$cell = $worksheet->getCellByColumnAndRow(5, $row);
				$maxtmp = $cell->getValue();
				$cell = $worksheet->getCellByColumnAndRow(6, $row);
				$mintmp = $cell->getValue();
				$cell = $worksheet->getCellByColumnAndRow(7, $row);
				$rain = $cell->getValue();
				$cell = $worksheet->getCellByColumnAndRow(8, $row);
				$avgrh = $cell->getValue();
				$cell = $worksheet->getCellByColumnAndRow(9, $row);
				$evapor = $cell->getValue();
				$cell = $worksheet->getCellByColumnAndRow(10, $row);
				$meantemp = $cell->getValue();
		
				if( $row < $highestRow) // push some data for preview
				{
		
					
					try {
						$result =  DB::table('tbl_rain_measurement')->insert(
                                                        array(
								'station_id' => $sta_id,
								'meas_date' => $dyear . '-' . $dmonth . '-' . $dday,
								'max_temp' => $maxtmp,
								'min_temp' => $mintmp,
								'rain' => $rain,
								'avgrh' => $avgrh,
								'evapor' => $evapor,
								'mean_temp' => $meantemp,
								'source' => 1 //source from excel
						));
					} catch (\Exception $exc) {
						//echo $exc->getTraceAsString();
					}
				}
			}
		
		
		
		
	}
	
	
    public function _text($path){
		
		
		$lines = file($path);
		
		
		$month= array("04","05","06","07","08","09","10","11","12","01","02","03");
		
		
		$temp = array();
		$year = 0;
		$meas_date = "";
		$day = 0;
		$LOG = array();
		$frist = true;
		
		$sql = "INSERT INTO `rain`.`tbl_rain_measurement` ( `meas_date`, `station_id`, `rain`, `source`) VALUES";
		foreach ($lines as $line_num => $line)
		{
		
		

			$page = floor($line_num/61);
			if ($line_num == 6+61*$page)
			{
				$year = substr($line,65,4);
			}
			if ($line_num == 4+61*$page)
			{
				$station_id = substr($line,14,4);
			}
		
			if($line_num >= 14+61*$page && $line_num <= 46+61*$page && $line_num != 24+61*$page && $line_num != 35+61*$page)
			{
				 
				if($day > 31)$day =0;$day++;
				for ($column =0;$column <12;$column++)
				{
		
				$meas_date = $year."-".$month[$column] ."-".$day;
				if(checkdate((int)$month[$column],(int)$day, (int)$year))
				{
				$rain = substr($line,13+8*$column,8);
				if($rain == "        ")array_push($LOG,$meas_date."    ".'NULL');
				else if ($rain == "      - ")array_push($LOG,$meas_date."    ".'N/A');
				else
				{
				if($frist)
				{
		
				$sql = $sql."('".$meas_date."','".(int)$station_id."','".(float)$rain."','3')";
				$frist = false;
				}
				else  $sql = $sql.",('".$meas_date."','".(int)$station_id."','".(float)$rain."','3')";
				 
				}
				}
		
				}
				}
				 
				}
				
				try {
				Yii::app()->db->createCommand($sql)->execute();
				}
				catch (CDbException $e)
				{
					echo $e->getTraceAsString();
					
				}

		
		        foreach ($LOG as $key => $value)
				{
		
                }
		
		}        

    }