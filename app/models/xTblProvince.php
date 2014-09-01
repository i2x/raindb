<?php

class xTblProvince extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_province';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'province_name' => 'required',
					
			)
	);
	
	
	
	return $validator;
	
	}



}

