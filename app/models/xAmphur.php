<?php

class xAmphur extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'amphur';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'AMPHUR_CODE' => 'required|numeric',
					'AMPHUR_NAME' => 'required',
					'GEO_ID' => 'required|numeric',
					'PROVINCE_ID' => 'required|numeric'
			)
	);
	
	
	
	return $validator;
	
	}



}

