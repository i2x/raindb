<?php
class ReportController extends Controller
{
	
	public function getIndex()
	{
		
		
		
	$weekly  = $this->getWeekly(NULL,NULL);
	$monthly = $this->getMonthly(NULL,NULL,NULL,NULL);
	
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
			Input::get('end'),
			Input::get('only_rainy_day'));
	
	
	
	
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
		if(isset($start))    $condition."AND meas_date <=  '2000-08-06'";
		if(isset($end)) 	 $condition."AND meas_date >=  '1998-08-06'";

	
		
			$weekly = DB::select(DB::raw("
			
			SELECT 		date_part('year',meas_date) AS _YEAR,
		    date_part( 'week', meas_date ) AS _week,
			SUM(  rain ) AS _weeksum,
			ROUND( AVG(  rain )::numeric ,2 ) AS _weekavg,
			MIN(  rain )   AS _weekmin,
			MIN( NULLIF(  rain , 0 ) ) AS _weekmin2,				
			MAX(  rain )   AS _weekmax		
			FROM  tbl_rain_measurement
			WHERE  station_id in (327301,327007)
			AND meas_date >=  '1996-08-06'
			AND meas_date <=  '2000-08-06'		
			GROUP BY date_part('year',meas_date) ,date_part( 'week', meas_date) 
			
			"));
			
			
			
			return $weekly;
	}
	public function getMonthly($station,$start,$end,$only_rainy_day)
	{
		
		
		
		
		
		if($station == NULL)$station = 327022;
		if($start != NULL) $start = "AND  meas_date >=  '".$start."' ";
		if($end != NULL) $end = "AND  meas_date <=  '".$end."' ";
		if($only_rainy_day != NULL)
		{
		$sql = "
				ROUND( AVG(  rain )::numeric ,2 ) AS _monthavg,				
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
			WHERE  station_id IN(".$station.")
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
	

	
	public function boxplotMonth($station,$start,$end)
	{

		if($station == NULL) $station = 327016;
		if($start != NULL) $start = "AND  meas_date >=  '".$start."' ";
		if($end != NULL) $end = "AND  meas_date <=  '".$end."' ";
				
		$monthly = DB::select(DB::raw("
		
		SELECT  meas_year ,  meas_month ,  rain
		FROM  tbl_rain_measurement
		WHERE  station_id IN(".$station.")
		".$start." ".$end."	
		AND rain > 0"));
		
		

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
	
	
	public function boxplot_encode($boxplotMonth)
	{

		$i = 0;
                $boxplot= array();
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