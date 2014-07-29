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



}
