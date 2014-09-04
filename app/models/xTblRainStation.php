<?php

class xTblRainStation extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_rain_station';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'name' => 'required',
					'province' => 'required',
					'basin_id' => 'required',
					
			)
	);
	
	
	
	return $validator;
	
	}



}

