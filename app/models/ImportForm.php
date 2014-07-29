<?php

use functional;
class ImportForm extends Eloquent{


	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	

	
	protected $table = 'tbl_temp_measurement';
	
	
	public static $rules = array(
			'file' => 'required | excel',
			
			
				
	);
	
	
	
	public static function  validate($data)
	{
		
		
		//request file Type Excel 
		
		Validator::extend('excel', function($attribute, $value, $parameters)
		{
			
		//MIME types
			$allowed = array(
					
			'application/vnd.ms-office',
			
			);
			
			$mime = $value->getMimeType();
			return in_array($mime, $allowed);
		});
			
		
		$messages = array(
				
				'excel' => '*The file field must be a file of type: application/vnd.ms-office (.xls).<br>
				*can add MIME types in <code> /app/models/ImportForm </code> 
				',
				
		);

	
		return Validator::make($data, static::$rules,$messages);
	
	}
	
	



}

