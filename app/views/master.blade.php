<?php 
//Check Group admin
$admin = false;
if (Sentry::check()){
$group = Sentry::getUser()->getGroups()->toarray();
if( $group[0]['pivot']['group_id'] == 2 )$admin = true;
}
?>




<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Rain - @yield('title')</title>
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
		      
		      @if($admin)
		      
		      <a class="navbar-brand" style="padding-left:1em" href="{{URL::to('admin')}}">     <span class="glyphicon glyphicon-cloud">    </span>
		      
		     @else
		     
		     <a class="navbar-brand" style="padding-left:1em" href="{{URL::to('/')}}"">     <span class="glyphicon glyphicon-cloud">    </span>
		     
		     
		     @endif
		      
		      
		      
		       </a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li class="{{ set_active('/') }}"><a href="{{ URL::to('/') }}">Home</a></li>
		        <li class="{{ set_active('historical') }}"><a href="{{ URL::to('historical') }}">Historical Data</a></li>
		        
<!--		        <li class="{{ set_active('about') }}"><a href="/about">About</a></li>
		        <li class="{{ set_active('contact') }}"><a href="/contact">Contact</a></li> --> 
		        <li class="{{ set_active('graph') }}"><a href="{{ URL::to('graph') }}">Graph</a></li>
		        <li class="{{ set_active('import') }}"><a href="{{ URL::to('import') }}">Import</a></li>
		        <li class="{{ set_active('log') }}"><a href="{{URL::to('log') }}">Log</a></li>
		        <li class="{{ set_active('report') }}"><a href="{{ URL::to('report') }}">Report</a></li>
		        <li class="{{ set_active('#') }}"><a href="/userProtected">Forecast</a></li>
		     
		      </ul>

		      <ul class="nav navbar-nav navbar-right">
		      
		      
		    
	   @if (!Sentry::check())
					<li class="{{ set_active('register') }}"><a href="{{URL::to('register') }}">Sing up</a></li>
					<li class="{{ set_active('login') }}"><a href="{{URL::to('login') }}">Login</a></li>
		
		
            
          </ul>			
		@else
				
				
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          
          <span class="glyphicon glyphicon-user"></span>
					<?php 
					
					$name = User::where('id', '=', Sentry::getUser()->getId())->get()->toArray();
					echo $name[0]['first_name'];?> 
          
          
          <span class="caret"></span></a>
          
          <ul class="dropdown-menu" role="menu">
         
             
                   	   @if($admin)
            			
            			<li><a href="{{URL::to('admin')}}">
						<span class="glyphicon glyphicon-cog"></span> 
						Admin Panel</a></li>

					@else
						<li><a href="/profiles/{{Sentry::getUser()->id}}">
						<span class="glyphicon glyphicon-cog"></span> Setting Profile
						</a></li>
					@endif
		
            
            
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="/logout">
            <span class="glyphicon glyphicon-log-out"></span>
            Logout</a></li>
            
          </ul>
        </li>
		
				
				@endif
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











