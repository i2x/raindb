<?php


class SelectController extends Controller {
	
	public function province()
	{
		
		$province = DB::select(DB::raw("select tbl_province.province_id,tbl_province.province_name from tbl_province
		where tbl_province.province_id in (
		select distinct(tbl_province.province_id) from tbl_province inner join tbl_rain_station on
		tbl_rain_station.province = tbl_province.province_id
		inner join riverbasin on riverbasin.basin_id = tbl_rain_station.basin_id
		where riverbasin.basin_id IN(".Input::get('id')."))"));
		
		
		
		$dropdown = '<option value=""></option>';
		foreach($province as $value):
		$dropdown .= '<option value="'.$value->province_id.'">'.$value->province_name.'</option>';
		endforeach;
		return Response::make($dropdown);
	}


	public function ampher(){
		

		$ampher = DB::select(DB::raw("	select tbl_ampher.ampher_id,tbl_ampher.name from tbl_ampher
		where tbl_ampher.ampher_id in (
		select distinct(tbl_ampher.ampher_id) from tbl_ampher inner join tbl_rain_station on
		tbl_rain_station.ampher = tbl_ampher.ampher_id
		inner join tbl_province on tbl_province.province_id = tbl_rain_station.province
		where tbl_province.province_id IN(' ".Input::get('id')."  '))"));
		
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