@extends('protected.admin.master')

@section('title', 'List Table')

@section('content')

	<ol class="breadcrumb">
  	<li><a href="{{URL::to('database')}}">Database</a></li>
  	<li class="active">Index</li>
	</ol>
	
	<div class="page-header">
	
	</div>
	

	<table class="table table-striped table-bordered table-hover">
		<thead>
	        <tr>
	          <th>#</th>
	          <th>Table Name</th>
	          <th>Attributes</th>
	        </tr>
      	</thead>
      	      		<?php $i = 1?>
		@foreach ($contents['name'] as $key => $name)
      	<tbody>
      		
      		@if($contents['link'][$key] != '#')
    		<tr>
	      		<td>{{ $i++ }}</td>
		        <td><a href="{{URL::to('database').'/'.$name}}">{{$name}}</a> </td>
		        <td>{{$contents['attributes'][$key] }}</td>
		        
		     </tr>
			@endif
			@endforeach
		
      	</tbody>
	</table>



@stop


<?php 





?>



@stop