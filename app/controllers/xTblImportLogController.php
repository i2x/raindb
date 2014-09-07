<?php 

class xTblImportLogController extends AdminController {



	
//GET 

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	public function getData()
	{
		
		$groups = DB::table('tbl_import_log')->select(array('logid', 'importdate', 'filename', 'url' ,'message', 'level', 'detail'));
		return Datatables::of($groups)
		->add_column('actions',
				 '<a href="{{{ URL::to(\'database/tbl_import_log/\' . $logid . \'/update
				\' ) }}}" class="btn btn-default btn-xs iframe" >Edit</a>
				
				<a class="btn btn-xs btn-danger" onclick="Delete({{{  $logid  }}})"
				 href="javascript:void(0)">Delete</a>
				
				
				
				
				
				
				
            ')
		->make();

		
	}
	
//END GET

	
// INDEX
	public function index()
	{
	
		return View::make('crud.tbl_import_log.table');
	}
	
	
// END INDEX

	
//EDIT
	
public function getUpdate($post)
	{
		$ampher_message = NULL;
		if(Session::get('amphur_message') != NULL) 
		{
			$ampher_message = Session::get('amphur_message');
			Session::forget('amphur_message');
		}
		Session::put('post',$post);
		$ampher = xTblImportLog::where('logid',$post)->first()->toArray();
		return View::make('crud.tbl_import_log.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> tbl_import_log')
		->with('ampher_message',$ampher_message)
		->with('mode','Edit')
		
		;
		
		
	}
public function postUpdate($id)
	{
		
		//		$groups = DB::table('tbl_import_log')->select(array('logid', 'province_name' ,'region_id'));
		
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblImportLog::validate($input);
		if($validator->fails())return Redirect::to('database/tbl_import_log/'.$id.'/update')->withErrors($validator);
		
		try {
			
			DB::table('tbl_import_log') ->where('logid', $id)->update($input);
			Session::put('amphur_message','<div class="alert alert-success" role="alert">update success. </div>');
			if(isset($input['logid']))$id = $input['logid'];
			return Redirect::to('database/tbl_import_log/'. $id.'/update');
		}
	
			catch (Exception $e) {
				Session::put('amphur_message','<div class="alert alert-danger" role="alert">update fail.</div>');
				return Redirect::to('database/tbl_import_log/'.$id.'/update');
			}
	
	}
	
	//END EDIT
	
	
	// CREATE
	
	public function getCreate()
	{
		
		
	
		return View::make('crud.tbl_import_log.create_edit')
		->with('ampher_message','')
		->with('title','Create  Import Logs')
		->with('mode','Create')
		;
	
	}
	
	
	
	public function postCreate()
	{
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblImportLog::validate($input);

	   if($validator->fails())
	   {
	   		return Redirect::to('database/tbl_import_log/create')->withErrors($validator);
	   }
	
		try {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert"> create success.</div>');
			if(isset($input['logid'])) $last = $input['logid'];
			else $input['logid'] = xTblImportLog::max('logid')+1;
			xTblImportLog::insert($input);
			return Redirect::to('database/tbl_import_log/'.$input['logid'].'/update');

		}
	
		catch (Exception $e) {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert">create fail. </div>');
			return Redirect::to('database/tbl_import_log/create');
	
		}
	
	
	
	
	}
//END CREATE

	//Delete

	

	public function postDelete($id)
	{
		
		DB::table('tbl_import_log')
		->where('logid', $id)
		->delete();

		
	
	}
	
	

	

}
























