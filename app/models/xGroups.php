<?php

class xGroups extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'groups';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'name' => 'required',
					
			)
	);
	
	
	
	return $validator;
	
	}



}

