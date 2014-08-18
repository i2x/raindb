<?php
class ReportController extends Controller
{
	
	public function getIndex()
	{
		
		
		
		

	$weekly  = $this->getWeekly(NULL,NULL);
	$monthly = $this->getMonthly(NULL,NULL);
	
	$box1avg = '';
	
	
	foreach ($weekly as $key => $value)
	{
		//print_r($value->_weeksum);
		$box1avg[$key] = $value->_weekavg;

	}
	
	
	$box1avg = $box1min = $box1max =  array();
	
	foreach ($weekly as $key => $value)
	{
		
		$box1avg[$key] = $value->_weekavg;
		$box1min[$key] = $value->_weekmin;
		$box1max[$key] = $value->_weekmax;

	}
	
	//// กราฟเดือน
	
	$data = $box1min;
	
	$min_boxplot =  array(min($data), $this->stats_stat_percentile ($data ,25   ),
			$this->array_median($data), $this->stats_stat_percentile ($data ,75 ),
			max($data));
	
	
	$data = $box1avg;
	
	$avg_boxplot = array(min($data), $this->stats_stat_percentile ($data ,25   ),
			$this->array_median($data), $this->stats_stat_percentile ($data ,75 ),
			max($data));
	
	
	$data = $box1max;
	
	
	
	$min_boxplot = array(min($data), $this->stats_stat_percentile ($data ,25   ),
			$this->array_median($data), $this->stats_stat_percentile ($data ,75 ),
			max($data));
	
	
	
	

	$box1avg = $this->stats_stat_percentile($box1avg, 75);
	
	 return View::make('report.index')
	 ->with('weekly',$weekly)
	 ->with('monthly',$monthly);
	}
	public function postIndex()
	{
		
	$only_rainy_day = Input::get('only_rainy_day');
	$weekly  = $this->getWeekly(Input::get('station'),NULL);
	$monthly = $this->getMonthly(NULL,NULL);
	return View::make('report.index')
	->with('weekly',$weekly)
	->with('monthly',$monthly)
	->with('only_rainy_day',$only_rainy_day)
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
	public function getMonthly($station,$year)
	{
		if(!isset($station))$station = 327022;
		
		
		$monthly = DB::select(DB::raw("	
			
			SELECT 	YEAR(`meas_date`) AS _YEAR,
			MONTH(  `meas_date` ) AS _month,
			ROUND( SUM(  `rain` ) , 2 ) AS _monthsum,
			ROUND( AVG(  `rain` ) , 2 ) AS _monthavg,
			ROUND( MIN(  `rain` ) , 2 ) AS _monthmin,
			ROUND( MAX(  `rain` ) , 2 ) AS _monthmax
			FROM  `tbl_rain_measurement`
			WHERE  `station_id` IN (327301,329201)
			AND  `meas_year` > 2001
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
	
	public function boxplotForm($arr)
	{
		
	}
	
	
	
	
	
	
	
	
	
	
	
}