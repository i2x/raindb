<?php


class SelectController extends Controller {


	public function ampher(){
		

		$ampher = Ampher::where('province_id',Input::get('id'))->select('ampher_id','name')->get();
		$dropdown = '<option value=""></option>';
		foreach($ampher as $value):
		$dropdown .= '<option value="'.$value->ampher_id.'">'.$value->name.'</option>';
		endforeach;
		return Response::make($dropdown);
	}
	
	public function station(){
		
		
	   $station = Station::where('ampher',Input::get('id'))->select('stationid','name')->get();
       $dropdown = '<option value=""></option>';
       foreach($station as $value):
       $dropdown .= '<option value="'.$value->stationid.'">'.$value->name.'</option>';
       endforeach;
       return Response::make($dropdown);
	
	}


}