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
	
	public function postIndex(){
	
		
		
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
		//var_dump($data);
                
        
                // data
                
                // report part
                
	$data_month = $this->boxplotMonth(
			Input::get('station'),
			Input::get('start'),
			Input::get('end'),
			Input::get('only_rainy_day')
	);

	
	$data_week = $this->boxplotWeek(
			Input::get('station'),
			Input::get('start'),
			Input::get('end'),
			Input::get('only_rainy_day')
				
	);
	
			
		
	$only_rainy_day = Input::get('only_rainy_day');
	
	$weekly  = $this->getWeekly(Input::all(),Input::get('start'),Input::get('end'),Input::get('only_rainy_day'));
	
	$monthly = $this->getMonthly(Input::all(),
			Input::get('start'),
			Input::get('end'),
			Input::get('only_rainy_day'));
		
	$boxplot_month = $this->boxplot_encode($data_month['boxplot_array'],'month');
	$boxplot_week = $this->boxplot_encode($data_week['boxplot_array'],'week');
	
	return View::make('graph.graph')
	->with('categories_boxplot_month',$data_month['categories'])
    ->with('categories_boxplot_week',$data_week['categories'])
	->with('weekly',$weekly)
	->with('monthly',$monthly)
	->with('boxplot_month',$boxplot_month)
	->with('boxplot_week',$boxplot_week)
		->with('data' , $data)
		->with('oldInput',Input::all());
                
	}

	public function graph($input){
	    $index = 0;	
            $stations = $input['station'];
            //var_dump($input);
            $graphs = array();
            $mean_temps = array();
            $date_lists = array();
            $date_year = '';
            $date_month='';
            $date_day = '';
            foreach($stations as $station){
                
		$data = HistoricData::select(array('mean_temp','meas_date','rain'))
		->where('station_id',$station)
		->where('meas_date','>=',$input['start'])
		->where('meas_date','<=',$input['end'].' 23:59:59')
		->orderBy('meas_date');
		if(isset($input['only_rainy_day']))$data->where('rain','>',0);
		$data = $data->get();
			
		$graph = ' ';
		$mean_temp = ' ';
		$date_list = ' ';
		for($i=0;$i < sizeof($data);$i++){
		
		$yrdata= strtotime(($data[$i]['meas_date']));
		if($i == 0){
				$graph = $graph.$data[$i]['rain'];
				$mean_temp =  $mean_temp.$data[$i]['mean_temp'];
				$date_list = $date_list.'"'.date('d M Y', $yrdata).'"';
                                $date_year = date('Y',$yrdata);
                                $date_month = date('M',$yrdata);
                                $date_day = date('d',$yrdata);
					}
		else
			{
				$graph = $graph.','.$data[$i]['rain'];
				$mean_temp = $mean_temp.','.$data[$i]['mean_temp'];
				$date_list = $date_list.',"'.date('d M Y', $yrdata).'"';
		
			}
										
		}
		
		array_push($graphs,$graph);
                array_push($mean_temps,$mean_temp);
                array_push($date_lists,$date_list);
              
                $index++;
            }
            return array('date_lists'=>$date_lists, 'graphs' => $graphs,'mean_temps'=>$mean_temps,'date_year' =>$date_year,'date_month' =>$date_month,'date_day' =>$date_day);
	}

	public function getWeekly($input,$start,$end,$only_rainy_day)
	{
		
		$province = $ampher = $station = " ";
		if($start != NULL) $start = "AND  to_char(meas_date,'YYYY-MM-DD') >=  '".$start."' ";
		if($end != NULL) $end = "AND  to_char(meas_date,'YYYY-MM-DD') <=  '".$end." 23:59:59' ";
		
		if($input['province'] != NULL )$province = "and province  in (".implode(',',$input['province']).")";
		if($input['ampher']   != NULL )$ampher = "and ampher    in (".implode(',',$input['ampher']).")";
		if($input['station']  != NULL )$station = "and stationid in (".implode(',',$input['station']).")";
		
		
		    $condition = "	
			select tbl_rain_station.stationid as station_id
			from tbl_rain_station
			where basin_id in ( ".implode(',',$input['basin']).") ".$province." ".$ampher." ".$station;
		    
		    
		    
		    if($only_rainy_day != NULL)
		    {
		    	$sql = "
				ROUND( AVG(  NULLIF(  rain , 0 ) )::numeric ,2 ) AS _weekavg,
				MIN( NULLIF(  rain , 0 ) ) AS _weekmin,
		    
		";
		    }
		    else
		    {
		    	$sql = "
				    AVG(  rain )  AS _weekavg,
					MIN(  rain )  AS _weekmin,
			
					";
		    }
		

			$weekly = DB::select(DB::raw("
			
			SELECT 		date_part('year',meas_date) AS _YEAR, date_part('month',min(meas_date)) as _MONTH,
		    date_part( 'week', meas_date ) AS _week, min(date_part( 'day', meas_date )) as _day,
			SUM(  rain ) AS _weeksum,
			".$sql."
			MAX(  rain )   AS _weekmax		
			FROM  tbl_rain_measurement
			WHERE  station_id in (".$condition.")
			".$start." ".$end."			
			GROUP BY date_part('year',meas_date) ,date_part( 'week', meas_date) 
			ORDER by _YEAR,_MONTH,_week ASC
					
			
			"));
			
			
			
			return $weekly;
	}
	public function getMonthly($input,$start,$end,$only_rainy_day)
	{
		
		
		
		
		$province = $ampher = $station = " ";
	
		
		if($input['province'] != NULL)$province = "and province  in ( ".implode(',',$input['province']).")";
		if($input['ampher']   != NULL)$ampher = "and ampher    in (".implode(',',$input['ampher']).")";
                
		if($input['station'] != NULL ){
                    $stationin = implode(',',$input['station']);
                    $station = "and stationid in ( ".$stationin.")";
                }
		
		if($start != NULL) $start = "AND  to_char(meas_date,'YYYY-MM-DD') >=  '".$start."' ";
		if($end != NULL) $end = "AND  to_char(meas_date,'YYYY-MM-DD') <=  '".$end." 23:59:59'  ";
		
		 $condition = "	
		select tbl_rain_station.stationid as station_id
		from tbl_rain_station
		where basin_id in (  ".implode(',',$input['basin']).") ".$province." ".$ampher." ".$station;
		    
		    
		if($only_rainy_day != NULL)
		{
		$sql = "
				ROUND( AVG(  NULLIF(  rain , 0 ) )::numeric ,2 ) AS _monthavg,				
				MIN( NULLIF(  rain , 0 ) ) AS _monthmin,
				
		";
		}
		else 
		{
			$sql = "
					ROUND( AVG(  rain )::numeric ,2 ) AS _monthavg,
					MIN(  rain )  AS _monthmin,
					
					";
		}
		$monthly = DB::select(DB::raw("	
			
			SELECT 	date_part('year',meas_date) AS _YEAR,
			date_part('month',  meas_date ) AS _month,
			SUM(  rain )   AS _monthsum,
			".$sql."
			MAX(  rain )   AS _monthmax
			FROM  tbl_rain_measurement
			WHERE  station_id IN(".$condition.")
			".$start." ".$end."			
			GROUP BY date_part('year',meas_date) ,date_part( 'month', meas_date )
			ORDER by _YEAR,_month ASC
			 "));
		return $monthly;
		
	}
	
	
	public function stats_stat_percentile($data,$percentile){
		if( 0 < $percentile && $percentile < 1 ) {
			$p = $percentile;
		}else if( 1 < $percentile && $percentile <= 100 ) {
			$p = $percentile * .01;
		}else {
			return "";
		}
		$count = count($data);
		$allindex = ($count-1)*$p;
		$intvalindex = intval($allindex);
		$floatval = $allindex - $intvalindex;
		sort($data);
		if(!is_float($floatval)){
			$result = $data[$intvalindex];
		}else {
			if($count > $intvalindex+1)
				$result = $floatval*($data[$intvalindex+1] - $data[$intvalindex]) + $data[$intvalindex];
			else
				$result = $data[$intvalindex];
		}
		return $result;
	}
	
	
	
	public function array_median($array) {
		// perhaps all non numeric values should filtered out of $array here?
		$iCount = count($array);
		if ($iCount == 0) {
			throw new DomainException('Median of an empty array is undefined');
		}
		// if we're down here it must mean $array
		// has at least 1 item in the array.
		$middle_index = floor($iCount / 2);
		sort($array, SORT_NUMERIC);
		$median = $array[$middle_index]; // assume an odd # of items
		// Handle the even case by averaging the middle 2 items
		if ($iCount % 2 == 0) {
			$median = ($median + $array[$middle_index - 1]) / 2;
		}
		return $median;
	}
	

	
	public function boxplotMonth($station,$start,$end,$only_rainy_day)
	{
		
		
		$rain = " ";
		if($station == NULL) $station = array(327016);
		if($start != NULL) $start = "AND  meas_date >=  '".$start."' ";
		if($end != NULL) $end = "AND  meas_date <=  '".$end." 23:59:59'  ";
		if($only_rainy_day != NULL)
		{
			$rain = "and rain > 0";
		}
		
                
                $stationin = implode(',',$station);
				
		$monthly = DB::select(DB::raw("
		
		SELECT  meas_year ,  meas_month ,  rain
		FROM  tbl_rain_measurement
		WHERE  station_id IN(".$stationin.")
		".$start." ".$end." ".$rain."
		ORDER by meas_year,meas_month ASC
		"));
		
		

		$boxplot_array = $temp = array();
		$categories =array();
		$i = 0;
		
		foreach ( $monthly as $key => $value)
		{
			$temp[$value->meas_year][$value->meas_month][$key] = $value->rain;
		}
		
		
	
		foreach ($temp as $year => $array_month)
		{
			foreach ($array_month as $month => $_array)
			{
				$boxplot_array[$year][$month]['max'] = max($_array);
				$boxplot_array[$year][$month]['min'] = min($_array);
				$boxplot_array[$year][$month]['median'] = $this->array_median($_array);
				$boxplot_array[$year][$month]['upper'] = $this->stats_stat_percentile($_array, 75);
				$boxplot_array[$year][$month]['lower'] = $this->stats_stat_percentile($_array, 25);
				
				$jd=gregoriantojd($month,1,1);
				$categories[$i++] = jdmonthname($jd,0)." '".substr($year,2);
		
			}
		}
		
		
		return array('boxplot_array' =>$boxplot_array,'categories' => json_encode($categories));
		
		
	}
	
	
	
	
	public function boxplotWeek($station,$start,$end,$only_rainy_day)
	{
	
		$rain = " ";
		if($station == NULL) $station = array(327016);
		if($start != NULL) $start = "AND  meas_date >=  '".$start."' ";
		if($end != NULL) $end = "AND  meas_date <=  '".$end." 23:59:59'  ";
		
		if($only_rainy_day != NULL)
		{
			$rain = "and rain > 0";
		}
	
                
                $stationin = implode(',',$station);
                
                
		$monthly = DB::select(DB::raw("
	
		SELECT 		meas_year,
		date_part( 'week', meas_date ) AS _week,  rain
		FROM  tbl_rain_measurement
		WHERE  station_id IN(".$stationin.")
		".$start." ".$end." ".$rain."		
		ORDER by meas_year,_week ASC
		"));
	
	
	
		$boxplot_array = $temp = array();
		$categories =array();
		$i = 0;
	
		foreach ( $monthly as $key => $value)
		{
			$temp[$value->meas_year][$value->_week][$key] = $value->rain;
		}
	
	
	
		foreach ($temp as $year => $array_week)
		{
			foreach ($array_week as $week => $_array)
			{
				$boxplot_array[$year][$week]['max'] = max($_array);
				$boxplot_array[$year][$week]['min'] = min($_array);
				$boxplot_array[$year][$week]['median'] = $this->array_median($_array);
				$boxplot_array[$year][$week]['upper'] = $this->stats_stat_percentile($_array, 75);
				$boxplot_array[$year][$week]['lower'] = $this->stats_stat_percentile($_array, 25);

				$categories[$i++] = $year." (".$week.")";
	
			}
		}
	
	
		return array('boxplot_array' =>$boxplot_array,'categories' => json_encode($categories));
	
	
	}
	
	
	public function boxplot_encode($boxplotMonth,$mode)
	{

		$i = 0;
       	$boxplot= array();
       	
       	
		foreach ($boxplotMonth as $year =>$array_month)
		{
		
			foreach($array_month as ${$mode} => $arr)
			{
				$boxplot[$i++] = array(
						$boxplotMonth[$year][${$mode}]['min'],
						$boxplotMonth[$year][${$mode}]['lower'],
						$boxplotMonth[$year][${$mode}]['median'],
						$boxplotMonth[$year][${$mode}]['upper'],
						$boxplotMonth[$year][${$mode}]['max']);
			}
		}
		
		$boxplot_json = str_replace("\"", ' ', json_encode($boxplot));
		
		return $boxplot_json;
	}
	
	
	




}








?>