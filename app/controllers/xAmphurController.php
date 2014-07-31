<?php 

class xAmphurController extends AdminController {



	
//GET 




	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	public function getData_Ampher()
	{
		
		$amphur = DB::table('amphur')->select(array('amphur.AMPHUR_ID',
				 'amphur.AMPHUR_CODE', 'amphur.AMPHUR_NAME', 'amphur.GEO_ID','amphur.PROVINCE_ID'));
		return Datatables::of($amphur)
		->add_column('actions',
				 '<a href="{{{ URL::to(\'database/amphur/\' . $AMPHUR_ID . \'/edit\' ) }}}
				" class="btn btn-default btn-xs iframe" >
				Edit
				</a>
                <a href="{{{ URL::to(\'database/amphur/\' . $AMPHUR_ID . \'/delete\' ) }}}
				" class="btn btn-xs btn-danger iframe">
				Delete</a>
            ')
		->make();

		
	}
	
//END GET

	
// INDEX
	public function Index_Ampher()
	{
	
		return View::make('crud.amphur.index');
	}
	
	
// END INDEX

	
//EDIT
	
	public function Get_Edit_Ampher($post)
	{
		
		
		Session::put('post',$post);
		$ampher = xAmphur::where('AMPHUR_ID',$post)->first()->toArray();
		return View::make('crud.amphur.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> '.'AMPHUR ID: '.$post)
		;
		
		
	}
	public function Update_Ampher($post)
	{
		

		try {
	
			DB::table('amphur')
            ->where('AMPHUR_ID', $post)
            ->update(
            array(
            'AMPHUR_CODE' =>Input::get('AMPHUR_CODE'),
            'AMPHUR_NAME' => Input::get('AMPHUR_NAME'),
            'GEO_ID' => Input::get('GEO_ID'),
            'PROVINCE_ID' => Input::get('PROVINCE_ID'),
            ));
		
			// Redirect to the new ampher ..
			Session::put('update_success','Create Success');
			return Redirect::to('database/amphur/'. $post.'/edit');

		} catch (Exception $e) {
			

			Session::put('update_error','Create Fail');
		    return Redirect::to('database/amphur/'.$post.'/edit');

		}
			
	}
	
//END EDIT

	
// CREATE	
	
	public function Create_Ampher()
	{
	
		$ampher = '';
		return View::make('crud.amphur.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> '.'AMPHUR ID: '.$post)
		;

	}
//END CREATE
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	

}
























