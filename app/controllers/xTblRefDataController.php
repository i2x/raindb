<?php 

class xTblRefDataController extends AdminController {



	
//GET 

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	public function getData()
	{
		
		$groups = DB::table('tbl_ref_data')->select(array('id', 'meas_year' ,'meas_month',
				
		 'meas_value','refid'));
		return Datatables::of($groups)
		->add_column('actions',
				 '<a href="{{{ URL::to(\'database/tbl_ref_data/\' . $id . \'/update
				\' ) }}}" class="btn btn-default btn-xs iframe" >Edit</a>
				
				<a class="btn btn-xs btn-danger" onclick="Delete({{{  $id  }}})"
				 href="javascript:void(0)">Delete</a>')
		->make();

		
	}
	
//END GET

	
// INDEX
	public function index()
	{
	
		return View::make('crud.tbl_ref_data.table');
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
		$ampher = xTblRefData::where('id',$post)->first()->toArray();
		return View::make('crud.tbl_ref_data.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> tbl_ref_data')
		->with('ampher_message',$ampher_message)
		->with('mode','Edit')
		
		;
		
		
	}
	public function postUpdate($id)
	{
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblRefData::validate($input);
		if($validator->fails())return Redirect::to('database/tbl_ref_data/'.$id.'/update')->withErrors($validator);
	
		try {
	
			DB::table('tbl_ref_data') ->where('id', $id)->update($input);
			Session::put('amphur_message','<div class="alert alert-success" role="alert">update success. </div>');
			if(isset($input['id']))$id = $input['id'];
			return Redirect::to('database/tbl_ref_data/'. $id.'/update');}
	
			catch (Exception $e) {
	
				ion::put('amphur_message','<div class="alert alert-danger" role="alert">update fail.</div>');
				return Redirect::to('database/tbl_ref_data/'.$id.'/update');
			}
	
	}
	
//END EDIT

	
// CREATE	
	
	public function getCreate()
	{
	
		
		return View::make('crud.tbl_ref_data.create_edit')
		->with('ampher_message','')
		->with('title','Create  Ref Data')
		->with('mode','Create')
		;

	}
	
	
	public function postCreate()
	{
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblRefData::validate($input);
	
	
		if($validator->fails())return Redirect::to('database/tbl_ref_data/create')->withErrors($validator);
	
		try {
				
			Session::put('amphur_message','<div class="alert alert-success" role="alert"> create success.</div>');
			if(isset($input['id'])) $last = $input['id'];
			else $input['id'] = xTblRefData::max('id')+1;
			xTblRefData::insert($input);
			return Redirect::to('database/tbl_ref_data/'.$input['id'].'/update');
				
		}
	
		catch (Exception $e) {
				
			Session::put('amphur_message','<div class="alert alert-success" role="alert">create fail. </div>');
			return Redirect::to('database/tbl_ref_data/create');
	
		}
	
	
	
	
	}
//END CREATE

	//Delete

	

	public function postDelete($id)
	{
		
		DB::table('tbl_ref_data')
		->where('id', $id)
		->delete();

		
	
	}
	
	


	


	
	

	

}
























