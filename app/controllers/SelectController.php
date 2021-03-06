<?php


class SelectController extends Controller {
	
	public function province()
	{
		
                $province_array = Input::get('id');
                $provinces = '';
                foreach($province_array as $p){
                    if($provinces==''){
                        $provinces = $p;
                    }else {
                        $provinces = $provinces.",'".$p."'";
                    }
                }
                
		$province = DB::select(DB::raw("select tbl_province.province_id,tbl_province.province_name from tbl_province
		where tbl_province.province_id in (
		select distinct(tbl_province.province_id) from tbl_province inner join tbl_rain_station on
		tbl_rain_station.province = tbl_province.province_id
		inner join riverbasin on riverbasin.basin_id = tbl_rain_station.basin_id
		where riverbasin.basin_id IN(".$provinces."))"));
		
		
		
		$dropdown = '<option value=""></option>';
		foreach($province as $value):
		$dropdown .= '<option value="'.$value->province_id.'">'.$value->province_name.'</option>';
		endforeach;
		return Response::make($dropdown);
	}
	
	public function ampher(){
		
                $ampher_array = Input::get('id');
                $amphers = '';
                foreach($ampher_array as $p){
                    if($amphers==''){
                        $amphers = $p;
                    }else {
                        $amphers = $amphers.",'".$p."'";
                    }
                }
                
		$ampher = DB::select(DB::raw("	select tbl_ampher.ampher_id,tbl_ampher.name from tbl_ampher
		where tbl_ampher.ampher_id in (
		select distinct(tbl_ampher.ampher_id) from tbl_ampher inner join tbl_rain_station on
		tbl_rain_station.ampher = tbl_ampher.ampher_id
		inner join tbl_province on tbl_province.province_id = tbl_rain_station.province
		where tbl_province.province_id IN(".$amphers." ))"));
		
		$dropdown = '<option value=""></option>';
		foreach($ampher as $value):
		$dropdown .= '<option value="'.$value->ampher_id.'">'.$value->name.'</option>';
		endforeach;
		return Response::make($dropdown);
	}
	
	public function station(){

                $station_array = Input::get('id');
                $stations = '';
                foreach($station_array as $p){
                    if($stations==''){
                        $stations = $p;
                    }else {
                        $stations = $stations.",'".$p."'";
                    }
                }            
		
		$station = DB::select(DB::raw("	select tbl_rain_station.stationid,tbl_rain_station.name from tbl_rain_station
		where tbl_rain_station.ampher in (".$stations.")"));
		
		$dropdown = '<option value=""></option>';
		foreach($station as $value):
		$dropdown .= '<option value="'.$value->stationid.'">'.$value->name.'</option>';
		endforeach;
		return Response::make($dropdown);
	
	}
	
	
	static public function  save_province($input)
	{
	
		$province = DB::select(DB::raw("select tbl_province.province_id,tbl_province.province_name from tbl_province
		where tbl_province.province_id in (
		select distinct(tbl_province.province_id) from tbl_province inner join tbl_rain_station on
		tbl_rain_station.province = tbl_province.province_id
		inner join riverbasin on riverbasin.basin_id = tbl_rain_station.basin_id
		where riverbasin.basin_id IN(".$input."))"));
		foreach ($province as $key => $value)
		{
			$province_list[$value->province_id] = $value->province_name;
	
		}
		return $province_list;
	
	}
	
	static public function  save_amphur($input)
	{
	
		$ampher = DB::select(DB::raw("select tbl_ampher.ampher_id,tbl_ampher.name from tbl_ampher
		where tbl_ampher.ampher_id in (
		select distinct(tbl_ampher.ampher_id) from tbl_ampher inner join tbl_rain_station on
		tbl_rain_station.ampher = tbl_ampher.ampher_id
		inner join tbl_province on tbl_province.province_id = tbl_rain_station.province
		where tbl_province.province_id IN(' ".$input."  '))"));
		$amphur_list =array();
		foreach ($ampher as $key => $value)
		{
			$amphur_list[$value->ampher_id] = $value->name;
	
		}
		return $amphur_list;
	
	}
	
	
	static public function  save_station($input)
	{
	
		$station = $station = Station::where('ampher',$input)->select('stationid','name')->get();
		foreach ($station as $key => $value)
		{
			$station_list[$value->stationid] = $value->name;
	
		}
		return $station_list;
	
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
        
        public function baseMonth(){
            $lmonth= array(1=>'JAN',2=>'FEB',3=>'MAR',4=>'APR',5=>'MAY',6=>'JUN',7=>'JUL',8=>'AUG',9=>'SEP',10=>'OCT',11=>'NOV',12=>'DEC');

    		//echo Input::get('baseyear');
    		if(Input::get('baseyear') ==  date("Y"))
    		{

    			$mto = date("m")-2;
    			
    		}
    		else {
                    $mto =12;
    		}
                                  $data = array();
    			for($i=1;$i<=$mto ;$i++){
                            $data[$i]= $lmonth[$i];
                        }
  		$dropdown = '<option value=""></option>';
		foreach($data as $key=>$value):
		$dropdown .= '<option value="'.$key.'">'.$value.'</option>';
		endforeach;
		return Response::make($dropdown);
    	
            
        }


}