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



	<div class="container">
		@yield('content')
	</div>

	


    
    
    		
	<!-- Javascripts -->
    
 	{{ HTML::script('packages/jquery/jquery.min.js'); }}
	{{ HTML::script('packages/bootstrap/js/bootstrap.min.js'); }}
	
		
       


    @yield('scripts')

</body>
</html>












