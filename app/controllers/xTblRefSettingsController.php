<?php 

class xTblRefSettingsController extends AdminController {



	
//GET 

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	public function getData()
	{
		
		$tbl_ref_settings = DB::table('tbl_ref_settings')->select(array(
				'idtbl_ref_settings', 'basin_id', 'reftype', 'varname' ,'analysis_level' ,'latitude_from', 
				'latitude_to', 'longtitude_from', 'longtitude_to', 'time_scale', 'month_from',
				 'month_to', 'area_weight_grid' ,'source_url'));
		return Datatables::of($tbl_ref_settings)
		->add_column('actions',
				 '<a href="{{{ URL::to(\'database/tbl_ref_settings/\' . $idtbl_ref_settings . \'/update
				\' ) }}}" class="btn btn-default btn-xs iframe" >Edit</a>
				
				<a class="btn btn-xs btn-danger" onclick="Delete({{{  $idtbl_ref_settings  }}})"
				 href="javascript:void(0)">Delete</a>
				
				
				
				
				
				
				
            ')
		->make();

		
	}
	
//END GET

	
// INDEX
	public function index()
	{
		return View::make('crud.tbl_ref_settings.table');
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
		$ampher = xTblRefSettings::where('idtbl_ref_settings',$post)->first()->toArray();
		return View::make('crud.tbl_ref_settings.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> tbl_ref_settings')
		->with('ampher_message',$ampher_message)
		->with('mode','Edit')
	
		;
	
	
	}
	public function postUpdate($id)
	{
		$input = Input::get();
		unset($input['_token'] );
		
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblRefSettings::validate($input);
		if($validator->fails())return Redirect::to('database/tbl_ref_settings/'.$id.'/update')->withErrors($validator);
	
		try {
	
			DB::table('tbl_ref_settings') ->where('idtbl_ref_settings', $id)->update($input);
			Session::put('amphur_message','<div class="alert alert-success" role="alert">update success. </div>');
			if(isset($input['idtbl_ref_settings']))$id = $input['idtbl_ref_settings'];
			return Redirect::to('database/tbl_ref_settings/'. $id.'/update');
		}
	
		catch (Exception $e) {
			Session::put('amphur_message','<div class="alert alert-danger" role="alert">update fail.</div>');
			return Redirect::to('database/tbl_ref_settings/'.$id.'/update');
		}
	
	}
	
	//END EDIT
	
	
	// CREATE
	
	public function getCreate()
	{
	
	
	
		return View::make('crud.tbl_ref_settings.create_edit')
		->with('ampher_message','')
		->with('title','Create  Ref Settings')
		->with('mode','Create')
		;
	
	}
	
	
	
	public function postCreate()
	{
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblRefSettings::validate($input);
	
		if($validator->fails())
		{
			return Redirect::to('database/tbl_ref_settings/create')->withErrors($validator);
		}
	
		try {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert"> create success.</div>');
			if(isset($input['idtbl_ref_settings'])) $last = $input['idtbl_ref_settings'];
			else $input['idtbl_ref_settings'] = xTblRefSettings::max('idtbl_ref_settings')+1;
			xTblRefSettings::insert($input);
			return Redirect::to('database/tbl_ref_settings/'.$input['idtbl_ref_settings'].'/update');
	
		}
	
		catch (Exception $e) {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert">create fail. </div>');
			return Redirect::to('database/tbl_ref_settings/create');
	
		}
	
	
	
	
	}
//END CREATE

	//Delete

	

	public function postDelete($id)
	{
		
		DB::table('tbl_ref_settings')
		->where('idtbl_ref_settings', $id)
		->delete();

		
	
	}
	
	

	

}
























