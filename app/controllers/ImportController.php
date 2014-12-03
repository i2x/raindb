<?php

/*use Maatwebsite\Excel\Excel;
use Illuminate\Redis\Database;*/
class ImportController extends BaseController 
{






	/**
	 * Returns all the blog graph.
	 *
	 * @return View
	 */
	
	


	public function getImport()
	{
		
		//init
		ImportPreview::truncate();// Remove all of 'tbl_temp_measurement' table for preview
		DB::table('tbl_missing_measurement')->truncate();
		
		Session::forget('FRIST_DATE'); //for missing row
		
		
		
		// send message if upload success
		if (!empty(Session::get('success')))
		{
			$message = Session::get('success');
				
		}
		
		// default message for get /import
		else 
		{ 
			$message ="<div class='alert alert-info' role='alert'>
						Please select a file </div>";
		}
		$this->Clear();//Remove all Tempfile and Session
		

		// Render Import
		return View::make('import.import')->with('message',$message);

	}
	public function postImport()
	{
		//check input paramiter or file type input
		
       $validator = ImportForm::validate(Input::all());
        if($validator->fails())
		{
			//if file display eror message
			return View::make('import.import')->withErrors($validator)->with('message',' ');
				
			
		}
		
		
		
		//html
		
		
		if ($validator->passes() && Input::file('file')->getMimeType() == "text/html")
		{
		
			
			$file = Input::file('file');
			$fileName = $this->checkName($file->getClientOriginalName(),'.html');
			Session::put('filename',$fileName);
			Input::file('file')->move( base_path('temp'),$fileName); // import to temp folder
			$encode = new Html_Import(base_path('temp').'/'.$fileName);
			
			
			$data = $encode->getResult() ;
			
			DB::table('tbl_temp_measurement')->truncate();
				
			foreach ($data as $station => $value)
			{
				
				try {
					
					DB::table('tbl_temp_measurement')->insert($value);
						
					
				} catch (Exception $e) {
				}
			
			
			}
	
			
		/*	try {
				
				
				
				
			/*	foreach ($data as $station => $value)
				{
						
				
					DB::table('tbl_temp_measurement')->insert($value);
				//	$this->pushMissing($station,'html');
					DB::table('tbl_temp_measurement')->truncate();
				}
					
				foreach ($data as $station => $value)
				{
					DB::table('tbl_temp_measurement')->insert($value);
						
						
				}
					
				
		
			
			
			
			}
			catch (Exception $e)
			{
				
				
				return Redirect::to('import')->with('message' , 'file incorrect	');
				
			
					
			}
			*/
			
			
			//return View::make('import.preview')->with('fileName','<code>'.$fileName.'</code>');
				
			
			
			
				
			
				
			
		}
		
		
		//excel
	
		
		if ($validator->passes() && Input::file('file')->getMimeType() == "application/vnd.ms-office")
		{
			
			
			
	
	
	
		$file = Input::file('file');
		$fileName = $this->checkName($file->getClientOriginalName(),'xls');
		Session::put('filename',$fileName);
		Input::file('file')->move( base_path('temp'),$fileName); // import to temp folder
	
		Excel::load(base_path('temp/'.$fileName), function($reader) {
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
				 	
				 	$arr[$value['stncode']][] = $temp;
			 	}
			
			
			}
			
			 	
			 	try {
			 		
			 		
			 	
			 		//get missing
			 		foreach ($arr as $station => $value)
			 		{
			 			DB::table('tbl_temp_measurement')->insert($value);
			 			$this->pushMissing($station,'xls');
			 			DB::table('tbl_temp_measurement')->truncate();
			 						 			
			 		}
			 		//insert all data
			 		foreach ($arr as $station => $value)
			 		{
			 			DB::table('tbl_temp_measurement')->insert($value);
			 			 
			 			
			 		}
			 		
			 		
			 	} 
			 	catch (Exception $e) 
			 	{
			 		
			 	
			 	}
		}
		catch (Exception $e)
		{
			// file incorrect	

			return Redirect::to('import')->with('message' , 'file incorrect	');
		
				
		}
		
		
		
		
		
		
		

		
		});
		
		
		
			
		
		}
		
		$updatepart = "update tbl_rain_measurement 
set meas_year = date_part('year',cast(meas_date as timestamp )),
meas_month = date_part('month',cast(meas_date as timestamp )),
meas_day = date_part('day',cast(meas_date as timestamp ))
where meas_year is null";
                DB::update($updatepart);
		return View::make('import.preview')->with('fileName','<code>'.$fileName.'</code>');
		
		
	}
	

	public function getData()
	{
		
			$data = DB::table('tbl_temp_measurement')
				->leftJoin('tbl_rain_station',
				'tbl_temp_measurement.station_id','=','tbl_rain_station.stationid')
				->leftJoin('tbl_source',
						'tbl_temp_measurement.source','=','tbl_source.source_id')
				->select(array(
						
				'tbl_temp_measurement.meas_id',
				'tbl_temp_measurement.meas_date',
				'tbl_temp_measurement.station_id',
				'tbl_rain_station.name',		
				'tbl_temp_measurement.max_temp',
				'tbl_temp_measurement.min_temp',
				'tbl_temp_measurement.rain',
				'tbl_temp_measurement.avgrh',
				'tbl_temp_measurement.evapor',
				'tbl_temp_measurement.mean_temp',
				'tbl_source.source_name'
										

		));


			
	
		return  Datatables::of($data)->make();
	
	
	}
	

	
	
	public function pushMissing($station,$format)
	{
		
	
		if($format == 'xls')
		{
		$sql = "INSERT INTO tbl_missing_measurement(
            dt,meas_date, station_id, max_temp, min_temp, rain, avgrh, evapor, 
            mean_temp,meas_year,meas_month,meas_day, source )
   


			(select calendar_table.dt, 
				tbl_temp_measurement.meas_date,".$station.",
				tbl_temp_measurement.max_temp,tbl_temp_measurement.min_temp,tbl_temp_measurement.rain,
				tbl_temp_measurement.avgrh,tbl_temp_measurement.evapor,tbl_temp_measurement.mean_temp,
				tbl_temp_measurement.meas_year,tbl_temp_measurement.meas_month,tbl_temp_measurement.meas_day,
				tbl_temp_measurement.source
				
				from calendar_table left join tbl_temp_measurement on
 				tbl_temp_measurement.meas_date = calendar_table.dt
 				where calendar_table.dt >= (select min(tbl_temp_measurement.meas_date) from tbl_temp_measurement)
 				and calendar_table.dt <=   (select max(tbl_temp_measurement.meas_date) from tbl_temp_measurement)
				and (tbl_temp_measurement.meas_date is NULL or tbl_temp_measurement.rain is NULL)
				
				order by dt asc,station_id)";
		}
		if($format == 'html')
		{
			
			
			$sql = "INSERT INTO tbl_missing_measurement(
            dt,meas_date, station_id,rain )
   


			(select calendar_table.dt, 
				tbl_temp_measurement.meas_date,".$station.",
				tbl_temp_measurement.rain
				
				from calendar_table left join tbl_temp_measurement on
 				tbl_temp_measurement.meas_date = calendar_table.dt
 				 where calendar_table.dt <=   (select max(tbl_temp_measurement.meas_date) from tbl_temp_measurement)
				and calendar_table.dt >=  	'". Session::get('FRIST_DATE')[0]."' 
				and (tbl_temp_measurement.meas_date is NULL or tbl_temp_measurement.rain is NULL)
				order by dt asc,station_id)";
			
		}
		
		return DB::select(DB::raw($sql));
		
		
	
		
		
		
	}
	
	
	
	
	
	
	public function checkName($file,$type)
	{
		
	
		if(array_search($file, scandir(base_path().DIRECTORY_SEPARATOR . 'upload_files')))
		{
			$Name  = substr($file,0,-4).'_'.date('Y-m-d His').$type;
		}
		else 
		{
			$Name = $file;
		}
		return $Name;
	}
	
	public function toDatabase()
	{
		$att = Sentry::getUser()->email;
		$fileName = Session::get('filename');
		File::move(base_path('temp/').$fileName, base_path('upload_files/').$fileName);//Move File Form 'temp' To 'uploadFiles'UploadFiles
		ImportLog::insert(array(
			'filename'   => $fileName,
			'detail'     => 'imported by '.$att,
			
		));		
                $copytable = "
                    insert into tbl_rain_measurement
(meas_date,station_id,max_temp,min_temp,rain,avgrh,evapor,mean_temp,source,meas_year,meas_month,meas_day)
select 
tbl_temp_measurement.meas_date,	tbl_temp_measurement.station_id,	tbl_temp_measurement.max_temp,
	tbl_temp_measurement.min_temp,	tbl_temp_measurement.rain,	
tbl_temp_measurement.avgrh,
	tbl_temp_measurement.evapor,	tbl_temp_measurement.mean_temp,
	tbl_temp_measurement.source,	tbl_temp_measurement.meas_year,	tbl_temp_measurement.meas_month,	tbl_temp_measurement.meas_day
from tbl_temp_measurement
left join tbl_rain_measurement 
on (tbl_rain_measurement.meas_date = tbl_temp_measurement.meas_date
and tbl_rain_measurement.station_id = tbl_temp_measurement.station_id)
where tbl_rain_measurement.station_id is null
";       

$countinsert = "
select 
count(0)
from tbl_temp_measurement
left join tbl_rain_measurement 
on (tbl_rain_measurement.meas_date = tbl_temp_measurement.meas_date
and tbl_rain_measurement.station_id = tbl_temp_measurement.station_id)
where tbl_rain_measurement.station_id is null";
                $countinsertres = DB::select($countinsert);
                var_dump( $countinsert);
                DB::insert($copytable);
                $insert = 0;
                $update = 0;
                
//		$source = ImportPreview::get();
//		$insert = 0;
//		$update = 0;
//		foreach ($source as $source)
//		{ 
//			$target = DB::table('tbl_rain_measurement')
//			->where('station_id',$source['station_id'])
//			->where('meas_date',$source['meas_date'])
//			->where('source',$source['source']);
//			if($target->exists())
//			{
//				$target->update(
//						array(
//									
//								'max_temp' => $source['max_temp'],
//								'min_temp' => $source['min_temp'],
//								'rain' => $source['rain'],
//								'avgrh' => $source['avgrh'],
//								'mean_temp' => $source['mean_temp'],
//								'meas_year' => $source['meas_year'],
//								'max_temp' => $source['max_temp'],
//								'meas_month' => $source['meas_month'],
//								'meas_day' => $source['meas_day'],
//						));
//				$update++;
//			}
//			else
//			{
//                            try{
//				$target->insert(
//						array(
//								'station_id'=>$source['station_id'],
//								'meas_date'=>$source['meas_date'],
//								'source'=>$source['source'],
//								'max_temp' => $source['max_temp'],
//								'min_temp' => $source['min_temp'],
//								'rain' => $source['rain'],
//								'avgrh' => $source['avgrh'],
//								'mean_temp' => $source['mean_temp'],
//								'meas_year' => $source['meas_year'],
//								'max_temp' => $source['max_temp'],
//								'meas_month' => $source['meas_month'],
//								'meas_day' => $source['meas_day'],
//						));
//                            }catch (\Exception $e){
//                                //
//                            }
//				
//				$insert++;
//		
//			}
//		
//		}
		
		// send message upload success to $this->getIndex()
		Session::put('success',  "<div 
				class='alert alert-success' role='alert'>
				Upload successfully.
				Insert:&nbsp&nbsp".$insert."&nbsp&nbsprow
				Update:&nbsp&nbsp".$update."&nbsp&nbsprow
				</div> ");
		
		return Redirect::to('import');

		
		
	}
	
	public function Clear()
	{
		Session::forget('success'); //Remove all of the items from the session.
		Session::forget('filename');
		$files = glob(base_path('temp/*')); // get all file names
		foreach($files as $file){ // iterate files
			if(is_file($file))
				unlink($file); // delete file
		}
		
	}
	
	public function getTemplate()
	{
		$file= public_path(). "/template.xls";
		$headers = array(
				'Content-Type: application/excel',
		);
		return Response::download($file, 'template.xls', $headers);
	}
	
	public function getExample()
	{
		$file= public_path(). "/example.xls";
		$headers = array(
				'Content-Type: application/excel',
		);
		return Response::download($file, 'example.xls', $headers);
	}
	






}



class Html_Import
{
	
	public $result;
	public function Html_Import($file)
	{
		$temp = array();
		$html = file_get_contents($file, true);
		$doc = new DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($html);

		$xpath = new DOMXPath($doc);
		$arr = array();
		$row = $doc->getElementsByTagName('tr');
		foreach ($row as $key =>$node)
		{
			if($key > 1)	array_push($arr, $this->tdrows($node->childNodes) );
		
		}
		
		
		$only_one = true;
		foreach  ($arr as $key =>$node)
		{
			if(isset($node[2])) 
			{
				
				
				$station = substr($node[2], 0,6);
				$temp[$station.$key] = $this->html_decode($node,$station);
				
				
				
				if($only_one == true)
				{
				
				$frist_date =  '01/'.$node[3];
				
				$frist_date = str_replace('/', '-', $frist_date);
				$frist_date = date('Y-m-d', strtotime($frist_date));
				Session::push('FRIST_DATE', $frist_date);
				$only_one = false;
						
				}
				

		
			}
		
		}
		
		$this->result = $temp;

	}
	
	public function getResult()
	{
		return $this->result;
	}
	
	
	

	function tdrows($elements)
	{
		$str = array();
		foreach ($elements as $element)
		{
			array_push($str, $element->nodeValue  );
		}
		return $str;
	}
	
	
	function html_decode($node,$station)
	{
		
	$temp = array();
	

	for($i=4;$i<sizeof($node)-1;$i++)
	{
		$data =  ($i-3).'/'.$node[3];
		
		$date = str_replace('/', '-', $data);
		$date = date('Y-m-d', strtotime($date));
	
		
	
		if( is_numeric($node[$i]) && $this->validateDate(''.$date))
		{
			
			
			$temp[$i-4]['station_id'] =$station;				
			$temp[$i-4]['meas_date'] =$date;
			$temp[$i-4]['rain'] = $node[$i];
			$temp[$i-4]['source'] = 1;
			
			

		}
	}
	

	return $temp;
		
	}
	
	
	function validateDate($date, $format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	
	
	
	


	
	
	
	
	
	
	
	

	
	
}





















