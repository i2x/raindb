<?php

class xTblSource extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_source';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'source_name' => 'required',
			
					
					
					
			)
	);
	
	
	
	return $validator;
	
	}



}

