<?php 

class CRUDController extends AdminController {




	public function getIndex()
	{
	
		return View::make('crud.index');
	}
	
	public function AmpherIndex()
	{
	
		return View::make('crud.amphur.index');
	}
	

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData()
	{
		
		$amphur = DB::table('amphur')->select(array('amphur.AMPHUR_ID',
				 'amphur.AMPHUR_CODE', 'amphur.AMPHUR_NAME', 'amphur.GEO_ID','amphur.PROVINCE_ID'));

		
		return Datatables::of($amphur)

		
		->add_column('actions', '<a href="{{{ URL::to(\'admin/blogs/\' . $AMPHUR_ID . \'/edit\' ) }}}
				" class="btn btn-default btn-xs iframe" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a href="{{{ URL::to(\'admin/blogs/\' . $AMPHUR_ID . \'/delete\' ) }}}
				" class="btn btn-xs btn-danger iframe">{{{ Lang::get(\'button.delete\') }}}</a>
            ')
		
		            ->remove_column('id')
		
		
		->remove_column('AMPHUR_ID')
		->make();

		
	}

	

}
























