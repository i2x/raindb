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


        

        function postIndex() 
        
        {
            //TODO

        	
        	
        	$this->actionUpdate();
		
		return $this->getIndex();
        }
        
public function actionUpdate()
	{
		
		$update = 'Update';
		//$this->Moveto_upload_files();
		
		$files = $this->FileList();
		$path = '';
		foreach ($files as $file)
		{
			
			
			if(substr($file,-3) == "xls")
			{
				
				
				$this->push_temp($file);
				$this->_excel($file);
				
				
				
			}
			elseif (substr($file,-3) == "txt")
			{
				$this->_text($path);$type = ".txt";
				$this->Moveto_upload_files($file,$type);
				
				
				
			}
			else 
			{
				
			}
			
			
			
		}
		
		
		
		$from = base_path() . DIRECTORY_SEPARATOR . 'schedule'.DIRECTORY_SEPARATOR;
		
		return View::make('schedule.schedule');
				
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
	
	
	public function Moveto_upload_files($file,$type)
	{
		
		
		$new_name = $file; 
		if(array_search($file, scandir(base_path() . DIRECTORY_SEPARATOR . 'upload_files')))$new_name =substr($file,0,-4).date('Y-m-d His').$type;
		$from = base_path() . DIRECTORY_SEPARATOR . 'schedule'.DIRECTORY_SEPARATOR;
	    $to   = base_path() . DIRECTORY_SEPARATOR . 'upload_files'.DIRECTORY_SEPARATOR;
	    
	    $query = array(
	    		'filename' => $new_name,
	    		'detail' => 'update from schedule');

	    DB::table('tbl_import_log')->insert($query);
	
		$success = rename($from.$file, $to.$new_name);
				
	}
	

	
	public function _excel($fileName){
		
		
		File::move(base_path('schedule/').$fileName, base_path('upload_files/').$fileName);//Move File Form 'temp' To 'uploadFiles'UploadFiles
		
		ImportLog::insert(array(
			'filename'   => $fileName,
			'detail'     => 'import by schedule',
			
		));		
		$source = ImportPreview::get();
		$insert = 0;
		$update = 0;
		foreach ($source as $source)
		{ 
			$target = DB::table('tbl_rain_measurement')
			->where('station_id',$source['station_id'])
			->where('meas_date',$source['meas_date'])
			->where('source',$source['source']);
			if($target->exists())
			{
				$target->update(
						array(
									
								'max_temp' => $source['max_temp'],
								'min_temp' => $source['min_temp'],
								'rain' => $source['rain'],
								'avgrh' => $source['avgrh'],
								'mean_temp' => $source['mean_temp'],
								'meas_year' => $source['meas_year'],
								'max_temp' => $source['max_temp'],
								'meas_month' => $source['meas_month'],
								'meas_day' => $source['meas_day'],
						));
				$update++;
			}
			else
			{
				$target->insert(
						array(
								'station_id'=>$source['station_id'],
								'meas_date'=>$source['meas_date'],
								'source'=>$source['source'],
								'max_temp' => $source['max_temp'],
								'min_temp' => $source['min_temp'],
								'rain' => $source['rain'],
								'avgrh' => $source['avgrh'],
								'mean_temp' => $source['mean_temp'],
								'meas_year' => $source['meas_year'],
								'max_temp' => $source['max_temp'],
								'meas_month' => $source['meas_month'],
								'meas_day' => $source['meas_day'],
						));
				
				$insert++;
		
			}
		
		}

				
	}
	
	public function push_temp($fileName)
	{
		DB::table('tbl_temp_measurement')->truncate();
		Excel::load(base_path('schedule/'.$fileName), function($reader) {
			$results = $reader->toArray();
			$arr = array();
		
			try {
		
				foreach ($results as $value)
				{
					if(isset($value['year']) && isset($value['month']) && isset($value['dday'])  )
					
					{
						$temp = array(
		
								'meas_date'   => $value['year'].'-'.$value['month'].'-'.$value['dday'],
								'station_id'  => $value['stncode'],
								'max_temp' 	  => $value['maxtmp'],
								'min_temp' 	  => $value['mintmp'],
								'rain' 		  => $value['rain'],
								'avgrh' 	  => $value['avgrh'],
								'evapor'      => $value['evapor'],
								'mean_temp'	  => $value['meantemp'],
								'source'	  => 1,
								'meas_year'   => $value['year'],
								'meas_month'  => $value['month'],
								'meas_day'    => $value['dday'],
						);
		
						array_push($arr, $temp);
					}}
						
					try {
		
						DB::table('tbl_temp_measurement')->insert($arr);
		
		
					}
					catch (Exception $e)
					{
		
						return Redirect::to('import')->with('message' , 'file incorrect	');
						
					}
			}
			catch (Exception $e)
			{
				// file incorrect
		
				return Redirect::to('import')->with('message' , 'file incorrect	');
		
		
			}
		
		
		
		});
	}

	
	
   

    }