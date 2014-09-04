<?php 

class xPasswordRemindersController extends AdminController {



	
//GET 

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	public function getData()
	{
		
		$password_reminders = DB::table('password_reminders')->select(array('id','password_reminders.email',
				 'password_reminders.token', 'password_reminders.created_at'));
		return Datatables::of($password_reminders)
		->add_column('actions',
				 '<a href="{{{ URL::to(\'database/password_reminders/\' . $id . \'/update
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
	
		return View::make('crud.password_reminders.table');
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
		$ampher = xPasswordReminders::where('id',$post)->first()->toArray();
		return View::make('crud.password_reminders.create_edit')
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
		$validator = xPasswordReminders::validate($input);
		if($validator->fails())return Redirect::to('database/password_reminders/'.$id.'/update')->withErrors($validator);
	
		try {
	
			DB::table('password_reminders') ->where('id', $id)->update($input);
			Session::put('amphur_message','<div class="alert alert-success" role="alert">update success. </div>');
			if(isset($input['id']))$id = $input['id'];
			return Redirect::to('database/password_reminders/'. $id.'/update');}
	
			catch (Exception $e) {
	
				ion::put('amphur_message','<div class="alert alert-danger" role="alert">update fail.</div>');
				return Redirect::to('database/password_reminders/'.$id.'/update');
			}
	
	}
	
	//END EDIT
	
	
	// CREATE
	
	public function getCreate()
	{
		
	
	
		return View::make('crud.password_reminders.create_edit')
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
		$validator = xPasswordReminders::validate($input);
		
		
	
	   if($validator->fails())
	   {
	   		return Redirect::to('database/password_reminders/create')->withErrors($validator);
	   }
	
		try {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert"> create success.</div>');
			if(isset($input['id'])) $last = $input['id'];
			else $input['id'] = xPasswordReminders::max('id')+1;
			
			xPasswordReminders::insert($input);
			return Redirect::to('database/password_reminders/'.$input['id'].'/update');
				
			

	
		}
	
		catch (Exception $e) {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert">create fail. </div>');
			return Redirect::to('database/password_reminders/create');

			
				
	
		}
	
	
	
	
	}
//END CREATE

	//Delete

	

	public function postDelete($id)
	{
		
		DB::table('password_reminders')
		->where('id', $id)
		->delete();

		
	
	}
	
	

	

}
























