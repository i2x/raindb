<?php 

class CRUDController extends AdminController {




	public function getIndex()
	{
	
		return View::make('crud.index');
	}
	
	

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	
	/*
	 * CRUD MAP
	 * METHOD:  CREATE,GET,EDIT,DELETE
	 * TABLE:
	 * 
	 * 
	*/
	
	
//GET 
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
	
	public function Edit_Ampher($post)
	{
		
		$ampher = xAmphur::where('AMPHUR_ID',$post)->first()->toArray();
		return View::make('crud.amphur.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> '.'AMPHUR ID: '.$post)
		;
		
		
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
























