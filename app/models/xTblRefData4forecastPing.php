<?php

class xTblRefData extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_ref_data4forecast_ping';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'season' => 'required',
					'meas_value1' => 'required',
					'meas_value2' => 'required',
					'meas_value3' => 'required',
					'meas_value4' => 'required',
					'meas_value5' => 'required',
					
					
			)
	);
	
	
	
	return $validator;
	
	}



}

