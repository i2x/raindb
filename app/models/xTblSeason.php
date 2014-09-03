<?php

class xTblSeason extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_season';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'season' => 'required|max:3',
			
					
					
					
			)
	);
	
	
	
	return $validator;
	
	}



}

