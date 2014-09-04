<?php

class xPasswordReminders extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'password_reminders';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'email' => 'required',
					
			)
	);
	
	
	
	return $validator;
	
	}



}

