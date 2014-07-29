<?php

class LogController extends BaseController
{
	public function getLog()
	{
		return View::make('log.log');
	}
	public function getData()
	{

		$data = ImportLog::select(

		'importdate',
		'filename',
		'url',
		'message',
		'level',
		'detail');
		
	
		
		return  Datatables::of($data)


        ->make();
	}
	
}
