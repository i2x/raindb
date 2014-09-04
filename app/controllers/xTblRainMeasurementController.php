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
				'min_temp' ,'rain' ,'avgrh' ,'evapor' ,'mean_temp' ,'source'
				
				
				
				
				
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
		if(Session::get('tbl_rain_measurement') != NULL) 
		{
			$ampher_message = Session::get('tbl_rain_measurement');
			Session::forget('tbl_rain_measurement');
		}
		Session::put('post',$post);
		$ampher = xTblRainMeasurement::where('meas_id',$post)->first()->toArray();
		return View::make('crud.tbl_rain_measurement.create_edit')
		->with('data',$ampher)
		->with('title',' <span class="glyphicon glyphicon-edit"></span> tbl_rain_measurement')
		->with('ampher_message',$ampher_message)
		->with('mode','Edit')
		
		;
		
		
	}
public function postUpdate($id)
	{
		$input = Input::get();
		unset($input['_token'] );
		foreach($input as $key => $value)if($value == NULL)unset($input[$key]);
		$validator = xTblRainMeasurement::validate($input);
		if($validator->fails())return Redirect::to('database/tbl_rain_measurement/'.$id.'/update')->withErrors($validator);
		
		try {
	
			DB::table('tbl_rain_measurement') ->where('meas_id', $id)->update($input);
			Session::put('tbl_rain_measurement','<div class="alert alert-success" role="alert">update success. </div>');
			if(isset($input['meas_id']))$id = $input['meas_id'];
			return Redirect::to('database/tbl_rain_measurement/'. $id.'/update');
		}
	
			catch (Exception $e) {
				Session::put('tbl_rain_measurement','<div class="alert alert-danger" role="alert">update fail.</div>');
				return Redirect::to('database/tbl_rain_measurement/'.$id.'/update');
			}
	
	}
	
	//END EDIT
	
	
	// CREATE
	
	public function getCreate()
	{
		
		
	
		return View::make('crud.tbl_rain_measurement.create_edit')
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
		$validator = xTblRainMeasurement::validate($input);

	   if($validator->fails())
	   {
	   		return Redirect::to('database/tbl_rain_measurement/create')->withErrors($validator);
	   }
	
		try {
	
			Session::put('tbl_rain_measurement','<div class="alert alert-success" role="alert"> create success.</div>');
			if(isset($input['meas_id'])) $last = $input['meas_id'];
			else $input['meas_id'] = xTblRainMeasurement::max('meas_id')+1;
			xTblRainMeasurement::insert($input);
			return Redirect::to('database/tbl_rain_measurement/'.$input['meas_id'].'/update');

		}
	
		catch (Exception $e) {
	
			Session::put('tbl_rain_measurement','<div class="alert alert-success" role="alert">create fail. </div>');
			return Redirect::to('database/tbl_rain_measurement/create');
	
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
























