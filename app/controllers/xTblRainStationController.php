<?php 

class xTblRainStationController extends AdminController {



	
//GET 

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	public function getData()
	{
		
		$groups = DB::table('tbl_rain_station')->select(array('stationid', 
				
		'name', 'latitude', 'longtitude','msl', 'ampher', 'province','description','source','basin_id'));
		return Datatables::of($groups)
		->add_column('actions',
				 '<a href="{{{ URL::to(\'database/tbl_rain_station/\' . $stationid . \'/update
				\' ) }}}" class="btn btn-default btn-xs iframe" >Edit</a>
				
				<a class="btn btn-xs btn-danger" onclick="Delete({{{  $stationid  }}})"
				 href="javascript:void(0)">Delete</a>
				
				
				
				
				
				
				
            ')
		->make();

		
	}
	
//END GET

	
// INDEX
	public function index()
	{
	
		return View::make('crud.tbl_rain_station.table');
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
		$ampher = xTblRainStation::where('stationid',$post)->first()->toArray();
		return View::make('crud.tbl_rain_station.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> tbl_rain_station')
		->with('ampher_message',$ampher_message)
		->with('mode','Edit')
	
		;
	
	
	}
	public function postUpdate($id)
	{
		
		
	
		
		
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblRainStation::validate($input);
		if($validator->fails())return Redirect::to('database/tbl_rain_station/'.$id.'/update')->withErrors($validator);
	
		try {
	
			DB::table('tbl_rain_station') ->where('stationid', $id)->update($input);
			Session::put('amphur_message','<div class="alert alert-success" role="alert">update success. </div>');
			if(isset($input['stationid']))$id = $input['stationid'];
			return Redirect::to('database/tbl_rain_station/'. $id.'/update');
		}
	
		catch (Exception $e) {
			Session::put('amphur_message','<div class="alert alert-danger" role="alert">update fail.</div>');
			return Redirect::to('database/tbl_rain_station/'.$id.'/update');
		}
	
	}
	
	//END EDIT
	
	
	// CREATE
	
	public function getCreate()
	{
	
	
	
		return View::make('crud.tbl_rain_station.create_edit')
		->with('ampher_message','')
		->with('title','Create  Rain Station')
		->with('mode','Create')
		;
	
	}
	
	
	
	public function postCreate()
	{
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblRainStation::validate($input);
	
		if($validator->fails())
		{
			
			return Redirect::to('database/tbl_rain_station/create')->withErrors($validator);
		}
	
		try {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert"> create success.</div>');
			if(isset($input['stationid'])) $last = $input['stationid'];
			else $input['stationid'] = xTblRainStation::max('stationid')+1;
			xTblRainStation::insert($input);
			return Redirect::to('database/tbl_rain_station/'.$input['stationid'].'/update');
	
		}
	
		catch (Exception $e) {
	
			Session::put('amphur_message','<div class="alert alert-success" role="alert">create fail. </div>');
			return Redirect::to('database/tbl_rain_station/create');
	
		}
	
	
	
	
	}
//END CREATE

	//Delete

	

	public function postDelete($id)
	{
		
		DB::table('tbl_rain_station')
		->where('stationid', $id)
		->delete();

		
	
	}
	
	

	

}
























