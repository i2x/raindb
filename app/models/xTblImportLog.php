<?php

class xTblImportLog extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tbl_import_log';
	
	
	public static function  validate($data)
	{
	
	
	$validator = Validator::make($data,
			array(
					'filename' => 'required',
					
			)
	);
	
	
	
	return $validator;
	
	}



}

