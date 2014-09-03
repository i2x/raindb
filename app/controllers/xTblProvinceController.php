<?php 

class xTblProvinceController extends AdminController {



	
//GET 

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	public function getData()
	{
		
		$groups = DB::table('tbl_province')->select(array('province_id', 'province_name' ,'region_id'));
		return Datatables::of($groups)
		->add_column('actions',
				 '<a href="{{{ URL::to(\'database/tbl_province/\' . $province_id . \'/update
				\' ) }}}" class="btn btn-default btn-xs iframe" >Edit</a>
				
				<a class="btn btn-xs btn-danger" onclick="Delete({{{  $province_id  }}})"
				 href="javascript:void(0)">Delete</a>
				
				
				
				
				
				
				
            ')
		->make();

		
	}
	
//END GET

	
// INDEX
	public function index()
	{
	
		return View::make('crud.tbl_province.table');
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
		$ampher = xTblProvince::where('province_id',$post)->first()->toArray();
		return View::make('crud.tbl_province.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> tbl_province')
		->with('ampher_message',$ampher_message)
		->with('mode','Edit')
		
		;
		
		
	}
public function postUpdate($id)
	{
		
		//		$groups = DB::table('tbl_province')->select(array('province_id', 'province_name' ,'region_id'));
		
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblProvince::validate($input);
		if($validator->fails())return Redirect::to('database/tbl_province/'.$id.'/update')->withErrors($validator);
		
		try {
	
			DB::table('tbl_province') ->where('province_id', $id)->update($input);
			Session::put('amphur_message','<div class="alert alert-success" role="alert">update success. </div>');
			if(isset($input['province_id']))$id = $input['province_id'];
			return Redirect::to('database/tbl_province/'. $id.'/update');
		}
	
			catch (Exception $e) {
				Session::put('amphur_message','<div class="alert alert-danger" role="alert">update fail.</div>');
				return Redirect::to('database/tbl_province/'.$id.'/update');
			}
	
	}
	
	//END EDIT
	
	
	// CREATE
	
	public function getCreate()
	{
		
		
	
		return View::make('crud.tbl_province.create_edit')
		->with('ampher_message','')
		->with('title','Create Amphur')
		->with('mode','Create')
		;
	
	}
	
	
	
	public function postCreate()
	{
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblProvince::validate($input);

	   if($validator->fails())
	   {
	   		return Redirect::to('database/tbl_province/create')->withErrors($validator);
	   }
	
		try {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert"> create success.</div>');
			if(isset($input['province_id'])) $last = $input['province_id'];
			else $input['province_id'] = xTblProvince::max('province_id')+1;
			xTblProvince::insert($input);
			return Redirect::to('database/tbl_province/'.$input['province_id'].'/update');

		}
	
		catch (Exception $e) {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert">create fail. </div>');
			return Redirect::to('database/tbl_province/create');
	
		}
	
	
	
	
	}
//END CREATE

	//Delete

	

	public function postDelete($id)
	{
		
		DB::table('tbl_province')
		->where('province_id', $id)
		->delete();

		
	
	}
	
	

	

}
























