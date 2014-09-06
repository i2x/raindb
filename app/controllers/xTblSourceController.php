<?php 

use Illuminate\Support\Facades\Session;
class xTblSourceController extends AdminController {



	
//GET 

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	public function getData()
	{
		
		$groups = DB::table('tbl_source')->select(array('source_id','source_name'));
		return Datatables::of($groups)
		->add_column('actions',
				 '<a href="{{{ URL::to(\'database/tbl_source/\' . $source_id . \'/update
				\' ) }}}" class="btn btn-default btn-xs iframe" >Edit</a>
				
				<a class="btn btn-xs btn-danger" onclick="Delete({{{  $source_id  }}})"
				 href="javascript:void(0)">Delete</a>
				
				
				
				
				
				
				
            ')
		->make();

		
	}
	
//END GET

	
// INDEX
	public function index()
	{
	
		return View::make('crud.tbl_source.table');
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
		$ampher = xTblSource::where('source_id',$post)->first()->toArray();
		return View::make('crud.tbl_source.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> tbl_source')
		->with('ampher_message',$ampher_message)
		->with('mode','Edit')
		
		;
		
		
	}
public function postUpdate($id)
	{
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblSource::validate($input);
		if($validator->fails())return Redirect::to('database/tbl_source/'.$id.'/update')->withErrors($validator);
		
		try {
	
			DB::table('tbl_source') ->where('source_id', $id)->update($input);
			Session::put('amphur_message','<div class="alert alert-success" role="alert">update success. </div>');
			if(isset($input['source_id']))$id = $input['source_id'];
			return Redirect::to('database/tbl_source/'. $id.'/update');
		}
	
			catch (Exception $e) {
				Session::put('amphur_message','<div class="alert alert-danger" role="alert">update fail.</div>');
				return Redirect::to('database/tbl_source/'.$id.'/update');
			}
	
	}
	
	//END EDIT
	
	
	// CREATE
	
	public function getCreate()
	{
		
		
	
		return View::make('crud.tbl_source.create_edit')
		->with('ampher_message','')
		->with('title','Create  Source')
		->with('mode','Create')
		;
	
	}
	
	
	
	public function postCreate()
	{
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblSource::validate($input);

	   if($validator->fails())
	   {
	   		return Redirect::to('database/tbl_source/create')->withErrors($validator);
	   }
	
		try {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert"> create success.</div>');
			if(isset($input['source_id'])) $last = $input['source_id'];
			else $input['source_id'] = xTblSource::max('source_id')+1;
			xTblSource::insert($input);
			return Redirect::to('database/tbl_source/'.$input['source_id'].'/update');

		}
	
		catch (Exception $e) {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert">create fail. </div>');
			return Redirect::to('database/tbl_source/create');
	
		}
	
	
	
	
	}
//END CREATE

	//Delete

	

	public function postDelete($id)
	{
		
		DB::table('tbl_source')
		->where('source_id', $id)
		->delete();

		
	
	}
	
	

	

}
























