@extends('master')

@section('title', 'Login')

@section('content')


	<div class="container">
	    <div class="row">
			<div class="col-md-6 col-md-offset-3">
	    		<div class="panel panel-default">
				  	<div class="panel-heading">
				    	<h3 class="panel-title">Login</h3>
				 	</div>
				  	<div class="panel-body">
				    	{{ Form::open(['route' => 'sessions.store']) }}
	                    <fieldset>
	                    
	                    
	                 
	                    	@if (Session::has('flash_message'))
								<p style="padding:5px" class="bg-success text-success">{{ Session::get('flash_message') }}</p>
							@endif

							@if (Session::has('error_message'))
								<p style="padding:5px" class="bg-danger text-danger">{{ Session::get('error_message') }}</p>
								<?php Session::forget('error_message')?>
							@endif

				    	  	<!-- Email field -->
							<div class="form-group">
								{{ Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control', 'required' => 'required'])}}
								{{ errors_for('email', $errors) }}
							</div>

				    		<!-- Password field -->
							<div class="form-group">
								{{ Form::password('password', ['placeholder' => 'Password','class' => 'form-control', 'required' => 'required'])}}
								{{ errors_for('password', $errors) }}
							</div>

				    	    	<!-- Remember me field -->
								<div class="form-group">
									{{ Form::checkbox('remember', 'remember') }}
									{{ Form::label('remember', 'Remember Me? ')}}
								</div>

				    		<!-- Submit field -->
							<div class="form-group">
								{{ Form::submit('Login', ['class' => 'btn btn btn-lg btn-success btn-block']) }}
							</div>
				    	</fieldset>
				      	{{ Form::close() }}
				    </div>
				</div>
				<div style="text-align:center">
					<p><a href="{{ URL::to('forgot_password')}}">Forgot Password?</a></p>

					<!--<p><strong>User:</strong> user@user.com<br>
					<strong> User Password:</strong> 123456</p>

					<p><strong>Admin:</strong> admin@admin.com<br>
					<strong>Admin Password:</strong> 123456</p>-->
				</div>


			</div>
		</div>
	</div>

@stop