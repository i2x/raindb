@extends('master')

@section('title', 'Contact')

@section('content')

<h2>Contact</h2>
	<p>For inquiries, please contact people in the following list.</p>
	<table class="table table-striped table-bordered table-hover">
		<thead>
	        <tr>
	          <th>Email</th>
	          <th>First Name</th>
	          <th>Last Name</th>
	        </tr>
      	</thead>
    

      	<tbody>
      		@foreach ($users as $user)
      		<tr>
		        @if ($user->inGroup($admin))
                    <td><a href="mailto:{{  $user->email }}">{{  $user->email }}</a>
		        </td>
		        <td>{{ $user->first_name}}</td>
		        <td>{{ $user->last_name}}</td>
		        @endif
		     </tr>
			@endforeach

      	</tbody>
	</table>


	
	
	

	
	
	
	

@stop
