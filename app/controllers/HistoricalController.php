<?php

use Illuminate\Redis\Database;
use Bllim\Datatables\Datatables;
class HistoricalController extends BaseController 
{


	/**
	 * Returns all the blog graph.
	 *
	 * @return View
	 */
	public function getIndex()
	{
	
		$this->Clear();		
		return View::make('historical.index');
	}
	
	
	public function postIndex()
	{
		

			
		Session::put('input', Input::all());
		return View::make('historical.historical')
		->with('oldInput',Input::all());
				
	}

	
	public function getData()
	{
		
		
		
	$data = HistoricData::leftJoin('tbl_rain_station',
				'tbl_rain_measurement.station_id','=','tbl_rain_station.stationid')
				->leftJoin('tbl_source',
						'tbl_rain_measurement.source','=','tbl_source.source_id')
				->select(
						
	//select 					
				array(
				'tbl_rain_measurement.meas_date',
				'tbl_rain_measurement.station_id',
				'tbl_rain_station.name',		
				'tbl_rain_measurement.max_temp',
				'tbl_rain_measurement.min_temp',
				'tbl_rain_measurement.rain',
				'tbl_rain_measurement.avgrh',
				'tbl_rain_measurement.evapor',
				'tbl_rain_measurement.mean_temp',
				'tbl_source.source_name'
										

		)
		
		/*DB::raw(
				'to_char(tbl_rain_measurement.meas_date,\'YYYY-MM-DD\'),
				tbl_rain_measurement.station_id,
				tbl_rain_station.name,		
				tbl_rain_measurement.max_temp,
				tbl_rain_measurement.min_temp,
				tbl_rain_measurement.rain,
				tbl_rain_measurement.avgrh,
				tbl_rain_measurement.evapor,
				tbl_rain_measurement.mean_temp,
				tbl_source.source_name')*/
		);
				
				
			
		$Input = Session::get('input');
		
		//var_dump($Input);
                
		
		
			if($Input['basin'] != NULL)$data->whereIn('basin_id',$Input['basin']);//
			if($Input['station'] != NULL)$data->whereIn('stationid',$Input['station']);
			if($Input['province'] != NULL)$data->whereIn('province',$Input['province']);
			if($Input['ampher'] != NULL)$data->whereIn('ampher',$Input['ampher']);
			if($Input['start'] != NULL)$data->where('meas_date','>=',$Input['start']);
			if($Input['end'] != NULL)$data->where('meas_date','<=',$Input['end'].' 23:59:59');
			if(isset($Input['only_rainy_day']))$data->where('rain','>',0);
							
			
			
		
			
		 	return  Datatables::of($data)->make();
		
		
	}
	

	public function Clear()
	{
		Session::forget('input'); //clear all session

	}



}


?>