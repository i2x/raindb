<?php

class xTblRefData extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_ref_data';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'meas_year' => 'required',
					'meas_month' => 'required',
					'meas_value' => 'required',
					
			)
	);
	
	
	
	return $validator;
	
	}



}

