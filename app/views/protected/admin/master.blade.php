<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>@yield('title') - Admin - Basic Auth Sentry</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Stylesheets -->
		{{ HTML::style('packages/bootstrap/css/bootstrap.min.css'); }}
		{{ HTML::style('packages/bootstrap/css/bootstrap-theme.min.css'); }}
		@yield('style')
		

	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->


</head>
<body>

	<header>

		<nav class="navbar navbar-default " role="navigation">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="{{URL::to(' ')}}">	<span class="glyphicon glyphicon-wrench"></span></a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li class="{{ set_active_admin('admin') }}"><a href="{{URL::to('admin')}}">Home</a></li>
  		        <li class="{{ set_active_admin('admin/profiles') }}"><a href="{{URL::to('/admin/profiles')}}">List Users</a></li>
  		        <li class="{{ set_active('database*') }}"><a href="{{ URL::to('database') }}">Database</a></li>
  		        
  		        <li class="{{ set_active('schedule') }}"><a href="{{ URL::to('schedule') }}">Schedule</a></li>
		        <li class="{{ set_active('refrefresh') }}"><a href="{{ URL::to('refrefresh') }}">Ref Refresh</a></li>
		        

		      </ul>

		      <ul class="nav navbar-nav navbar-right">

		        
		        
		        
		        
		            <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          
          <span class="glyphicon glyphicon-user"></span>
					<?php 
					
					$name = User::where('id', '=', Sentry::getUser()->getId())->get()->toArray();
					echo $name[0]['first_name'];?> 
          
          
          <span class="caret"></span></a>
          
          <ul class="dropdown-menu" role="menu">
         
            
            			
            			<li><a href="{{URL::to('/')}}">
						<span class="glyphicon glyphicon-cog"></span> 
						View Homepage</a></li>

	
		
            
            
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="/logout">
            <span class="glyphicon glyphicon-log-out"></span>
            Logout</a></li>
            
          </ul>
        </li>
		        
		        
		        
		        
		        
		        
		        
		        
		        
		        
		        
		        
		        
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>




	</header>

	<div class="container">
		@yield('content')
	</div>

	<!-- Javascripts -->
    
 	{{ HTML::script('packages/jquery/jquery.min.js'); }}
	{{ HTML::script('packages/bootstrap/js/bootstrap.min.js'); }}
	
		
       


    @yield('scripts')

</body>
</html>