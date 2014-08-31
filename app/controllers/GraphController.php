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
		->get();
			
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