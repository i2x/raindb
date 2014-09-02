<?php

class xTblRainMeasurement extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_rain_measurement';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'meas_date' => 'required',
					'station_id' => 'required',
					'rain' => 'required',
					
			)
	);
	
	
	
	return $validator;
	
	}



}

