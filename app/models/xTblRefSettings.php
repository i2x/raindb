<?php

class xTblRefSettings extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_ref_settings';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'basin_id' => 'required',
					'reftype' => 'required',
					'varname' => 'required',
					
					
					
			)
	);
	
	
	
	return $validator;
	
	}



}

