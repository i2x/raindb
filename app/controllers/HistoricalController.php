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
	

		
		/*$this->Clear();

		$validator = HistoricData::validate(Input::all());*/
		
		return View::make('historical.index');
		

    
	}
	
	
	public function postIndex()
	{
		
		/*$validator = HistoricData::validate(Input::all());
		$this->Passing(Input::get('province'), Input::get('ampher'), Input::get('station'));*/
		
		
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
				->select(array(
				'tbl_rain_measurement.meas_id',
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
										

		));
		$Input = Session::get('input');
		

			if($Input['station'] != NULL)$data->where('stationid',$Input['station']);
			if($Input['province'] != NULL)$data->where('province',$Input['province']);
			if($Input['ampher'] != NULL)$data->where('ampher',$Input['ampher']);
			if($Input['start'] != NULL)$data->where('meas_date','>=',$Input['start']);
			if($Input['end'] != NULL)$data->where('meas_date','<=',$Input['end']);

			
		 	return  Datatables::of($data)->make();
		
		
	}
	

	public function Passing($province,$ampher,$station)
	{
		if(!empty($province))Session::put('province_input', $province);
		if(!empty($ampher))Session::put('ampher_input', $ampher);
		if(!empty($station))Session::put('station_input', $station);
		
			
		
		
	
	}
	
	public function Clear()
	{
		Session::forget('province_input'); //clear all session
		Session::forget('ampher_input'); //clear all session
		Session::forget('station_input'); //clear all session
	}



}


?>