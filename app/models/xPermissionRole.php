<?php

class xPermissionRole extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'permission_role';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					
				)
	);
	
	
	
	return $validator;
	
	}



}

