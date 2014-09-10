<?php

class GraphController extends BaseController 
{

	
	



	/**
	 * Returns all the blog graph.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		
		
	
	    
		return View::make('graph.index');
	}
	
	public function postIndex()
	{
	
		
		
		$rules = array(
			
				'station' =>  'required',
				'start' =>  'required',
				'end' =>  'required',
				
		);
		
		$validator = Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return Redirect::to('graph')->withErrors($validator);
		}
		 
		
		$data = $this->graph(Input::all());
		
		return View::make('graph.graph')
		->with('data' , $data)
		->with('oldInput',Input::all());
	}

	public function graph($input)
	{
		
		$data = HistoricData::select(array('mean_temp','meas_date','rain'))
		->where('station_id',$input['station'])
		->where('meas_date','>=',$input['start'])
		->where('meas_date','<=',$input['end'])
		->orderBy('meas_date');
		if(isset($input['only_rainy_day']))$data->where('rain','>',0);
		$data = $data->get();
		
		
			
		$graph = ' ';
		$mean_temp = ' ';
		$date_list = ' ';
		for($i=0;$i < sizeof($data);$i++)
		{
		
		$yrdata= strtotime(($data[$i]['meas_date']));
		if($i == 0){
				$graph = $graph.$data[$i]['rain'];
				$mean_temp =  $mean_temp.$data[$i]['mean_temp'];
				$date_list = $date_list.'"'.date('d M Y', $yrdata).'"';
					}
		else
			{
				$graph = $graph.','.$data[$i]['rain'];
				$mean_temp = $mean_temp.','.$data[$i]['mean_temp'];
				$date_list = $date_list.',"'.date('d M Y', $yrdata).'"';
		
			}
										
		}
		
		return array('graph' => $graph,'mean_temp'=>$mean_temp,'date_list' =>$date_list);
	}

	
	
	




}








?>