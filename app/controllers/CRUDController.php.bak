<?php 

class CRUDController extends AdminController {



	public function getIndex()
	{
				
		
		$contents['name'] =
		array(
		/*1*/	'AuthAssignment',
		/*2*/	'AuthItem',
		/*3*/	'AuthItemChild',
		/*4*/	'Rights',
		/*5*/	'amphur',
		/*6*/	'assigned_roles',
		/*7*/	'calendar_table',
		/*8*/	'district',
		/*9*/	'geography',
		/*10*/	'groups',
		/*11*/	'ints',
		/*12*/	'migrations',
		/*13*/	'mo',
		/*14*/	'password_reminders',
		/*15*/	'permission_role',
		/*16*/	'permissions',
		/*17*/	'province',
		/*18*/	'riverbasin',
		/*19*/	'roles',
		/*20*/	'tbl_ampher',
		/*21*/	'tbl_import_log',
		/*22*/	'tbl_profiles',
		/*23*/	'tbl_profiles_fields',
		/*24*/	'tbl_province',
		/*25*/	'tbl_rain_measurement',
		/*26*/	'tbl_rain_station',
		/*27*/	'tbl_ref_data',
		/*28*/	'tbl_ref_data4forecast_ping',
		/*29*/	'tbl_ref_settings',
		/*30*/	'tbl_selected_stations');
		
		//  '#' mean Distable Table from old version
		$contents['link'] =
		array(
		/*1*/	'#',
		/*2*/	'#',
		/*3*/	'#',
		/*4*/	'#',
		/*5*/	'amphur',
		/*6*/	'#',
		/*7*/	'#',
		/*8*/	'district',
		/*9*/	'geography',
		/*10*/	'groups',
		/*11*/	'ints',
		/*12*/	'migrations',
		/*13*/	'mo',
		/*14*/	'password_reminders',
		/*15*/	'permission_role',
		/*16*/	'permissions',
		/*17*/	'province',
		/*18*/	'riverbasin',
		/*19*/	'roles',
		/*20*/	'tbl_ampher',
		/*21*/	'tbl_import_log',
		/*22*/	'#',
		/*23*/	'#',
		/*24*/	'tbl_province',
		/*25*/	'tbl_rain_measurement',
		/*26*/	'tbl_rain_station',
		/*27*/	'tbl_ref_data',
		/*28*/	'tbl_ref_data4forecast_ping',
		/*29*/	'tbl_ref_settings',
		/*30*/	'tbl_selected_stations');

		foreach ($contents['name'] as $key => $name)
		{
			$contents['attributes'][$key] = $this->getAttributes($name);
		}
		
		return View::make('crud.index')->with('contents',$contents);
	}
	
	
	
	
	function getAttributes($table)
	{
		$results = DB::select( DB::raw("
				
				
				select column_name
				from INFORMATION_SCHEMA.COLUMNS where table_name = '".$table."' ") );
		$arr = ' ';
		foreach ($results as $key => $value)
		{
			$temp =  '<code>'.$value->column_name.'</code>';
			$arr = $arr.$temp."  ".' ';
		}
	
		return $arr;
	
	
	}




}
























