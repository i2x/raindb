<?php 

class xGroupsController extends AdminController {



	
//GET 

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	public function getData()
	{
		
		$groups = DB::table('groups')->select(array('groups.id',
				 'groups.name', 'groups.permissions', 'groups.created_at','groups.updated_at'));
		return Datatables::of($groups)
		->add_column('actions',
				 '<a href="{{{ URL::to(\'database/groups/\' . $id . \'/update
				\' ) }}}" class="btn btn-default btn-xs iframe" >Edit</a>
				
				<a class="btn btn-xs btn-danger" onclick="Delete({{{  $id  }}})"
				 href="javascript:void(0)">Delete</a>
				
				
				
				
				
				
				
            ')
		->make();

		
	}
	
//END GET

	
// INDEX
	public function index()
	{
	
		return View::make('crud.groups.table');
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
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xGroups::validate($input);
		if($validator->fails())return Redirect::to('database/groups/'.$id.'/update')->withErrors($validator);
		
		try {
	
			DB::table('groups') ->where('id', $id)->update($input);
			Session::put('amphur_message','<div class="alert alert-success" role="alert">update success. </div>');
			if(isset($input['id']))$id = $input['id'];
			return Redirect::to('database/groups/'. $id.'/update');
		}
	
			catch (Exception $e) {
				Session::put('amphur_message','<div class="alert alert-danger" role="alert">update fail.</div>');
				return Redirect::to('database/groups/'.$id.'/update');
			}
	
	}
	
	//END EDIT
	
	
	// CREATE
	
	public function getCreate()
	{
		
		
	
		return View::make('crud.groups.create_edit')
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
		$validator = xGroups::validate($input);

	   if($validator->fails())
	   {
	   		return Redirect::to('database/groups/create')->withErrors($validator);
	   }
	
		try {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert"> create success.</div>');
			if(isset($input['id'])) $last = $input['id'];
			else $input['id'] = xGroups::max('id')+1;
			xGroups::insert($input);
			return Redirect::to('database/groups/'.$input['id'].'/update');

		}
	
		catch (Exception $e) {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert">create fail. </div>');
			return Redirect::to('database/groups/create');
	
		}
	
	
	
	
	}
//END CREATE

	//Delete

	

	public function postDelete($id)
	{
		
		DB::table('groups')
		->where('id', $id)
		->delete();

		
	
	}
	
	

	

}
























