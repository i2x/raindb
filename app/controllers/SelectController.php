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
	
	
	public function season()
	{
		
		if(Input::get('id') == 7)
		{
			$season = array(
					'MJJ'=>'MJJ',
					'ASO'=>'ASO',
					'NDJ'=>'NDJ',
					'FMA'=>'FMA',);
			 
			 
		}
		else {
			$season = array(
					'JFM'=>'JFM',
					'FMA'=>'FMA',
					'MAM'=>'MAM',
					'AMJ'=>'AMJ',
					'MJJ'=>'MJJ',
					'JJA'=>'JJA',
					'JAS'=>'JAS',
					'ASO'=>'ASO',
					'SON'=>'SON',
					'OND'=>'OND',
					'NDJ'=>'NDJ',
					'DJF'=>'DJF'
			);
		}
	 
		$dropdown = '<option value=""></option>';
		foreach($season as $value):
		$dropdown .= '<option value="'.$value.'">'.$value.'</option>';
		endforeach;
		return Response::make($dropdown);

		
	}


}