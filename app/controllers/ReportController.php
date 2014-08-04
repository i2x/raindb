<?php
class ReportController extends Controller
{
	
	public function getIndex()
	{
		
		
	 return View::make('report.index');
	}
	public function postIndex()
	{
		
	
	$weekly  = $this->getWeekly();
	$monthly = $this->getMonthly();
	return View::make('report.index')
	->with('weekly',$weekly)
	->with('monthly',$monthly);
	
		
		
	}
	public function getWeekly()
	{
			$weekly = DB::select(DB::raw("SELECT WEEK(  `meas_date` ) AS _week,
			ROUND( SUM(  `rain` ) , 2 ) AS _weeksum,
			ROUND( AVG(  `rain` ) , 2 ) AS _weekavg,
			ROUND( MIN(  `rain` ) , 2 ) AS _weekmin,
			ROUND( MAX(  `rain` ) , 2 ) AS _weekmax		
			FROM  `tbl_rain_measurement`
			WHERE  `station_id` =327301
			AND  `meas_year` =2006
			GROUP BY WEEK(  `meas_date` ) "));
			return $weekly;
	}
	public function getMonthly()
	{
		
	
		
		$monthly = DB::select(DB::raw("	SELECT MONTHNAME(  `meas_date` ) AS _month, 
		ROUND( SUM(  `rain` ) , 2 ) AS _monthsum,
	    ROUND( AVG(  `rain` ) , 2 ) AS _monthavg, 
		ROUND( MIN(  `rain` ) , 2 ) AS _monthmin,
		ROUND( MAX(  `rain` ) , 2 ) AS _monthmax
		FROM  `tbl_rain_measurement`
		WHERE  `station_id` =327301
		AND  `meas_year` =2006
		GROUP BY MONTH(  `meas_date` ) "));
		return $monthly;
		
	}
}