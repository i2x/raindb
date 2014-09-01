<?php

class xRiverbasin extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'riverbasin';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'basin_name' => 'required',
					
			)
	);
	
	
	
	return $validator;
	
	}



}

