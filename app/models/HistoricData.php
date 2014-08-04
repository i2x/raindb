<?php

class HistoricData extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_rain_measurement';
	

	public static $rules = array(
		'station' => 'required',
	);
	
	public static function  validate($data)
	{
		
		return Validator::make($data, static::$rules);
		
	}
	
	public function station()
	{
		return $this->hasOne('tbl_rain_station', 'stationid', 'station_id');
		
	}
	
	public static function getWeekly($station,$year)
	{
		$temp = HistoricData::select('rain','meas_date')
		->where('station_id',$station)
		->where('meas_year',$year)->get()->toarray();
		
		try {
			
			$data = array();
			
			foreach ($temp as $value)
			{
			
				$date = new DateTime($value['meas_date']);
				$week = $date->format("W");
				$data[(int)$week][$value['meas_date']] = $value['rain'];
			}
			$weekly = array();
			foreach ($data as $key => $value)
			{
				$weekly[$key]['max'] = max($value);
				$weekly[$key]['min'] = min($value);
				$weekly[$key]['avg'] = array_sum($value)/sizeof($value);
				$weekly[$key]['sum'] = array_sum($value);
			
			}
			
		} catch (Exception $e) {
			
			$weekly = NULL;
			
			
		}
	
		
		return $weekly;
	}
	



}
