<?php

use Illuminate\Redis\Database;
use Bllim\Datatables\Datatables;
class HistSumController extends BaseController 
{


	/**
	 * Returns all the blog graph.
	 *
	 * @return View
	 */
	public function getIndex()
	{
	
		$this->Clear();		
		return View::make('histsum.index');
	}
	
	
	public function postIndex()
	{
		Session::put('input', Input::all());
		return View::make('histsum.histsum')
		->with('oldInput',Input::all());
	}

	
	public function getData()
	{
	$data = Station::rightJoin(DB::raw("(select max(meas_date) as dto ,min(meas_date) dfrm,tbl_rain_measurement.station_id from tbl_rain_measurement group by station_id) 
as a"),'a.station_id', '=', 'tbl_rain_station.stationid')
				->leftJoin('riverbasin',
						'tbl_rain_station.basin_id','=','riverbasin.basin_id')
                                ->leftJoin('tbl_ampher','tbl_ampher.ampher_id','=','tbl_rain_station.ampher')
                                ->leftJoin('tbl_province','tbl_province.province_id','=','tbl_rain_station.province')
				->select(
	//select 					
				array(
				'riverbasin.basin_name',
                                    'tbl_province.province_name',
                                    'tbl_ampher.name as amname',
				'tbl_rain_station.name',
				'tbl_rain_station.stationid',		
				'a.dfrm',
				'a.dto'										
		)
		);
				
				
			
		$Input = Session::get('input');
			if($Input['basin'] != NULL){
                            if($Input['basin'] != 'Other'){
                            $data->where('riverbasin.basin_id','=',$Input['basin']);
                        }else {
                            $data->whereNull('riverbasin.basin_id');//DB::raw(' riverbasin.basin_id is null'));
                        }
                        }
			if(isset($Input['only_selected_station'])){
                            $data->join('tbl_selected_stations',function($join)
                         {
                             $join->on('tbl_selected_stations.station_id', '=', 'a.station_id');
                              //$join->on('tbl_selected_stations.basin_id', '=', 'riverbasin.basin_id');
                         });
                         //$data->whereNotNull('tbl_selected_stations.station_id','AND');
                        }
			
		 	return  Datatables::of($data)->make();
		
		
	}
	

	public function Clear()
	{
		Session::forget('input'); //clear all session

	}



}


?>