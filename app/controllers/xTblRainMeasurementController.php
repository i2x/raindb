<?php 

class xTblRainMeasurementController extends AdminController {



	
//GET 

	/**
	 * Show a list of all the blog posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	
	public function getData()
	{
		
		$groups = DB::table('tbl_rain_measurement')->select(array(
				'meas_id', 'meas_date', 'station_id' ,'max_temp', 
				'min_temp' ,'rain' ,'avgrh' ,'evapor' ,'mean_temp' ,'source', 
				'meas_year', 'meas_month' ,'meas_day'
				
				
				
				
		));
		return Datatables::of($groups)
		->add_column('actions',
				 '<a href="{{{ URL::to(\'database/tbl_rain_measurement/\' . $meas_id . \'/update
				\' ) }}}" class="btn btn-default btn-xs iframe" >Edit</a>
				
				<a class="btn btn-xs btn-danger" onclick="Delete({{{  $meas_id  }}})"
				 href="javascript:void(0)">Delete</a>
				
				
				
				
				
				
				
            ')
		->make();

		
	}
	
//END GET

	
// INDEX
	public function index()
	{
	
		return View::make('crud.tbl_rain_measurement.table');
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
		$ampher = xTblRainMeasurement::where('meas_id',$post)->first()->toArray();
		return View::make('crud.tbl_rain_measurement.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> '.'tbl_rain_measurement')
		->with('ampher_message',$ampher_message)
		->with('mode','Edit')
		
		;
		
		
	}
	public function postUpdate($id)
	{
		$input = Input::get();
		$validator = xAmphur::validate($input);
		
		if($validator->fails())
				{
				
			return Redirect::to('database/amphur/'.$id.'/update')->withErrors($validator);
			
		
				
		}

		try {
	
			DB::table('amphur')
            ->where('AMPHUR_ID', $id)
            ->update(
            array(
            'AMPHUR_CODE' =>Input::get('AMPHUR_CODE'),
            'AMPHUR_NAME' => Input::get('AMPHUR_NAME'),
            'GEO_ID' => Input::get('GEO_ID'),
            'PROVINCE_ID' => Input::get('PROVINCE_ID'),
            ));
		
			// Redirect to the new ampher ..
			
          
			Session::put('amphur_message','<div class="alert alert-success" role="alert">
            update success.
            </div>');
			return Redirect::to('database/amphur/'. $id.'/update');

		} catch (Exception $e) {
			

			Session::put('amphur_message','<div class="alert alert-danger" role="alert">
            update fail.
            </div>');
		    return Redirect::to('database/amphur/'.$id.'/update');

		}
			
	}
	
//END EDIT

	
// CREATE	
	
	public function getCreate()
	{
	
		
		return View::make('crud.amphur.create_edit')
		->with('ampher_message','')
		->with('title','Create Amphur')
		->with('mode','Create')
		;

	}
	
	public function postCreate()
	{
		$input = Input::get();
		$validator = xAmphur::validate($input);
	
		if($validator->fails())
		{
			
		   return Redirect::to('database/amphur/create')->withErrors($validator);
			
		}
		
		unset($input['_token']);
		try {
			Session::put('amphur_message','<div class="alert alert-success" role="alert">
            create success.
            </div>');
			$id = DB::table('amphur')->insertGetId($input);
			
			return Redirect::to('database/amphur/'. $id.'/update');
				
				
			
		} catch (Exception $e) {
			
			Session::put('amphur_message','<div class="alert alert-success" role="alert">
            create fail.
            </div>');
			return Redirect::to('database/amphur/create');
			
		}
		
	
		
		
	}
//END CREATE

	//Delete

	

	public function postDelete($id)
	{
		
		DB::table('amphur')
		->where('AMPHUR_ID', $id)
		->delete();

		
	
	}
	
	

	

}
























