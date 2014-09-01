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
				 '<a href="{{{ URL::to(\'database/amphur/\' . $logid . \'/update
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
		$ampher = xGroups::where('id',$post)->first()->toArray();
		return View::make('crud.groups.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> '.'AMPHUR ID: '.$post)
		->with('ampher_message',$ampher_message)
		->with('mode','Edit')
		
		;
		
		
	}
	public function postUpdate($id)
	{
		$input = Input::get();
		$validator = xAmphur::validate($input);
		
		if($validator->fails())
				{
				
			return Redirect::to('database/amphur/'.$id.'/update')->withErrors($validator);
			
		
				
		}

		try {
	
			DB::table('amphur')
            ->where('AMPHUR_ID', $id)
            ->update(
            array(
            'AMPHUR_CODE' =>Input::get('AMPHUR_CODE'),
            'AMPHUR_NAME' => Input::get('AMPHUR_NAME'),
            'GEO_ID' => Input::get('GEO_ID'),
            'PROVINCE_ID' => Input::get('PROVINCE_ID'),
            ));
		
			// Redirect to the new ampher ..
			
          
			Session::put('amphur_message','<div class="alert alert-success" role="alert">
            update success.
            </div>');
			return Redirect::to('database/amphur/'. $id.'/update');

		} catch (Exception $e) {
			

			Session::put('amphur_message','<div class="alert alert-danger" role="alert">
            update fail.
            </div>');
		    return Redirect::to('database/amphur/'.$id.'/update');

		}
			
	}
	
//END EDIT

	
// CREATE	
	
	public function getCreate()
	{
	
		
		return View::make('crud.amphur.create_edit')
		->with('ampher_message','')
		->with('title','Create Amphur')
		->with('mode','Create')
		;

	}
	
	public function postCreate()
	{
		$input = Input::get();
		$validator = xAmphur::validate($input);
	
		if($validator->fails())
		{
			
		   return Redirect::to('database/amphur/create')->withErrors($validator);
			
		}
		
		unset($input['_token']);
		try {
			Session::put('amphur_message','<div class="alert alert-success" role="alert">
            create success.
            </div>');
			$id = DB::table('amphur')->insertGetId($input);
			
			return Redirect::to('database/amphur/'. $id.'/update');
				
				
			
		} catch (Exception $e) {
			
			Session::put('amphur_message','<div class="alert alert-success" role="alert">
            create fail.
            </div>');
			return Redirect::to('database/amphur/create');
			
		}
		
	
		
		
	}
//END CREATE

	//Delete

	

	public function postDelete($id)
	{
		
		DB::table('amphur')
		->where('AMPHUR_ID', $id)
		->delete();

		
	
	}
	
	

	

}
























