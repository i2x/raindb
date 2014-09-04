<?php

class xTblSelectedStations extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_selected_stations';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'station_id' => 'required',
					
					
					
			)
	);
	
	
	
	return $validator;
	
	}



}

