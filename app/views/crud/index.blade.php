@extends('protected.admin.master')

@section('title', 'List Table')

@section('content')

	<ol class="breadcrumb">
  	<li><a href="{{URL::to('database')}}">Database</a></li>
  	<li class="active">Index</li>
	</ol>
	
	<div class="page-header">
	
	</div>
	
	
<?php 
	
	

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
/*17*/	'รายชื่อจังหวัด',
/*18*/	'รายชื่อลุ่มน้ำ',
/*19*/	'roles',
/*20*/	'รายชื่ออำเภอ',
/*21*/	'tbl_import_log',
/*22*/	'#',
/*23*/	'#',
/*24*/	'รายชื่อจังหวัด',
/*25*/	'ค่าที่วัด',
/*26*/	'รายชื่อสถานี',
/*27*/	'tbl_ref_data',
/*28*/	'tbl_ref_data4forecast_ping',
/*29*/	'tbl_ref_settings',
/*30*/	'tbl_selected_stations');


	
?>

	<table class="table table-striped table-bordered table-hover">
		<thead>
	        <tr>
	          <th>#</th>
	          <th>Table Name</th>
	          <th>Attributes</th>
	        </tr>
      	</thead>
    

      	<tbody>
      		<?php $i = 1?>
      		@foreach ($contents['name'] as $key => $name)
      		@if($contents['link'][$key] != '#')
      		
      		<tr>
	      		<td>{{ $i++ }}</td>
		        <td><a href="{{URL::to('database').'/'.$name}}">{{$name}}</a> </td>
		        
		        
		        <td>{{getAttributes($name)}}</td>

		     </tr>
		    @else
		    @endif
			@endforeach

      	</tbody>
	</table>



@stop


<?php 

function getAttributes($table)
{
	$results = DB::select( DB::raw("SHOW COLUMNS FROM  ".$table." ") );
	$arr = ' '; 
	foreach ($results as $key => $value)
	{
		$temp =  '<code>'.$value->Field.'</code>';
		$arr = $arr.$temp."  ".' ';
	}
	
	return $arr;
	
	
}



?>



@stop