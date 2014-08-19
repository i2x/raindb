<?php
class ReportController extends Controller
{
	
	public function getIndex()
	{
		
		
		
	$weekly  = $this->getWeekly(NULL,NULL);
	$monthly = $this->getMonthly(NULL,NULL,NULL);
	
	$data = $this->boxplotMonth(NULL,NULL,NULL);
	$test = $this->boxplot_encode($data['boxplot_array']);

	

	 return View::make('report.index')
	 ->with('categories_boxplot1',$data['categories'])
	 ->with('weekly',$weekly)
	 ->with('monthly',$monthly)
	 ->with('test',$test);	 
	 
	}
	
	
	
	
	public function postIndex()
	{
		
	$data = $this->boxplotMonth(Input::get('station'),
			Input::get('start'),
			Input::get('end')
	);	
	$test = $this->boxplot_encode($data['boxplot_array']);
		
		
	$only_rainy_day = Input::get('only_rainy_day');
	
	$weekly  = $this->getWeekly(Input::get('station'),NULL);
	
	$monthly = $this->getMonthly(Input::get('station'),
			Input::get('start'),
			Input::get('end'));
	
	
	return View::make('report.index')
	->with('categories_boxplot1',$data['categories'])
	->with('weekly',$weekly)
	->with('monthly',$monthly)
	->with('test',$test)
	->with('oldInput', Input::all());
		
		
	}
	public function getWeekly($station,$year)
	{
		$range = '';
		if(isset($start))    $condition."AND `meas_date` <=  '2000-08-06'";
		if(isset($end)) 	 $condition."AND `meas_date` >=  '1998-08-06'";

	
		
			$weekly = DB::select(DB::raw("SELECT 		YEAR(`meas_date`) AS _YEAR,
		    WEEK(  `meas_date` ) AS _week,
			ROUND( SUM(  `rain` ) , 3 ) AS _weeksum,
			ROUND( AVG(  `rain` ) , 3 ) AS _weekavg,
			ROUND( MIN(  `rain` ) , 3 ) AS _weekmin,
			ROUND( MIN( NULLIF(  `rain` , 0 ) ),3) AS _weekmin2,				
			ROUND( MAX(  `rain` ) , 3 ) AS _weekmax		
			FROM  `tbl_rain_measurement`
			WHERE  `station_id` =327301
			AND `meas_date` >=  '1996-08-06'
			AND `meas_date` <=  '2000-08-06'		
			GROUP BY YEAR(`meas_date`) ,WEEK(  `meas_date` )  "));
			
			
			
			return $weekly;
	}
	public function getMonthly($station,$start,$end)
	{
		if(!isset($station))$station = 327022;
		if($start != NULL) $start = "AND  `meas_date` >=  '".$start."' ";
		if($end != NULL) $end = "AND  `meas_date` <=  '".$end."' ";
		
		
		$monthly = DB::select(DB::raw("	
			
			SELECT 	YEAR(`meas_date`) AS _YEAR,
			MONTH(  `meas_date` ) AS _month,
			ROUND( SUM(  `rain` ) , 2 ) AS _monthsum,
			ROUND( AVG(  `rain` ) , 2 ) AS _monthavg,
			ROUND( MIN(  `rain` ) , 2 ) AS _monthmin,
			ROUND( MAX(  `rain` ) , 2 ) AS _monthmax
			FROM  `tbl_rain_measurement`
			WHERE  `station_id` IN(".$station.")
			".$start." ".$end."	
			GROUP BY YEAR(`meas_date`) ,MONTH(  `meas_date` )
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
	

	
	public function boxplotMonth($station,$start,$end)
	{

		if($station == NULL) $station = 327016;
		if($start != NULL) $start = "AND  `meas_date` >=  '".$start."' ";
		if($end != NULL) $end = "AND  `meas_date` <=  '".$end."' ";
				
		$monthly = DB::select(DB::raw("
		
		SELECT  `meas_year` ,  `meas_month` ,  `rain`
		FROM  `tbl_rain_measurement`
		WHERE  `station_id` IN(".$station.")
		".$start." ".$end."	
		AND `rain` > 0"));
		
		

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
				
				$categories[$i++] = $month." '".substr($year,2);
		
			}
		}
		
		
		return array('boxplot_array' =>$boxplot_array,'categories' => json_encode($categories));
		
		
	}
	
	
	public function boxplot_encode($boxplotMonth)
	{

		$i = 0;
		foreach ($boxplotMonth as $year =>$array_month)
		{
		
			foreach($array_month as $month => $arr)
			{
				$boxplot[$i++] = array(
						$boxplotMonth[$year][$month]['min'],
						$boxplotMonth[$year][$month]['lower'],
						$boxplotMonth[$year][$month]['median'],
						$boxplotMonth[$year][$month]['upper'],
						$boxplotMonth[$year][$month]['max']);
			}
		}
		
		$boxplot_json = str_replace("\"", ' ', json_encode($boxplot));
		
		return $boxplot_json;
	}
	
	

	

	


	
	
	
	
	
	
	
	
	
	
}