<?php 

use Illuminate\Support\Facades\Input;
class xRiverbasinController extends AdminController {



	
//GET 

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	public function getData()
	{
		
		$groups = DB::table('riverbasin')->select(array('basin_id','basin_name'));
		return Datatables::of($groups)
		->add_column('actions',
				 '<a href="{{{ URL::to(\'database/riverbasin/\' . $basin_id . \'/update
				\' ) }}}" class="btn btn-default btn-xs iframe" >Edit</a>
				
				<a class="btn btn-xs btn-danger" onclick="Delete({{{  $basin_id }}})"
				 href="javascript:void(0)">Delete</a>
				
				
				
				
				
				
				
            ')
		->make();

		
	}
	
//END GET

	
// INDEX
	public function index()
	{
	
		return View::make('crud.riverbasin.table');
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
		$ampher = xRiverbasin::where('basin_id',$post)->first()->toArray();
		return View::make('crud.riverbasin.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> riverbasin')
		->with('ampher_message',$ampher_message)
		->with('mode','Edit')
		
		;
		
		
	}
public function postUpdate($id)
	{
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xRiverbasin::validate($input);
		if($validator->fails())return Redirect::to('database/riverbasin/'.$id.'/update')->withErrors($validator);
		
		try {
	
			DB::table('riverbasin') ->where('basin_id', $id)->update($input);
			Session::put('amphur_message','<div class="alert alert-success" role="alert">update success. </div>');
			if(isset($input['basin_id']))$id = $input['basin_id'];
			return Redirect::to('database/riverbasin/'. $id.'/update');
		}
	
			catch (Exception $e) {
				Session::put('amphur_message','<div class="alert alert-danger" role="alert">update fail.</div>');
				return Redirect::to('database/riverbasin/'.$id.'/update');
			}
	
	}
	
	//END EDIT
	
	
	// CREATE
	
	public function getCreate()
	{
		
		
	
		return View::make('crud.riverbasin.create_edit')
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
		$validator = xRiverbasin::validate($input);

	   if($validator->fails())
	   {
	   		return Redirect::to('database/riverbasin/create')->withErrors($validator);
	   }
	
		try {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert"> create success.</div>');
			if(isset($input['basin_id'])) $last = $input['basin_id'];
			else $input['basin_id'] = xRiverbasin::max('basin_id')+1;
			xRiverbasin::insert($input);
			return Redirect::to('database/riverbasin/'.$input['basin_id'].'/update');

		}
	
		catch (Exception $e) {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert">create fail. </div>');
			return Redirect::to('database/riverbasin/create');
	
		}
	
	
	
	
	}
//END CREATE

	//Delete

	

	public function postDelete($id)
	{
		
		DB::table('riverbasin')
		->where('basin_id', $id)
		->delete();

		
	
	}
	
	

	

}
























