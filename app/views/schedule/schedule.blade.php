@extends('protected.admin.master')
@section('title', 'schedule  ')


@section('content')


	<table id="gridview" class="table table-striped table-hover" >
	
		<thead>
			<tr>
				<th class="col-md-3">date</th>
				<th class="col-md-3">file name</th>
				<th class="col-md-1">url</th>
				<th class="col-md-1">message</th>
				<th class="col-md-1">level</th>
				<th class="col-md-2">detail</th>
				
				
		
				
				
			</tr>
		</thead>
	</table>



{{ Form::open(array('url' => 'schedule' ,'method' => 'POST')) }}

<button class="btn btn-primary"><span class="glyphicon glyphicon-check"></span> schedule</button>



{{ Form::close() }}

@stop