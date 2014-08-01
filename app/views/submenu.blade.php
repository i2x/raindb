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
	
	
	
		<div class="page-header">
	
				<div class="push-right">
					<button class="btn btn-default btn-small btn-inverse close_popup"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</button>
				</div>
				
		<h4><center>{{$title}}</center> </h4>

		
		</div>
		
		
		@yield('content')

		
	</div>

	
	

    
    
    		
	<!-- Javascripts -->
    
 	{{ HTML::script('packages/jquery/jquery.min.js'); }}
	{{ HTML::script('packages/bootstrap/js/bootstrap.min.js'); }}
	{{ HTML::script('packages/datatables/js/jquery.dataTables.min.js')}}
	{{ HTML::script('packages/datatables/js/dataTables.bootstrap.js')}}
	{{ HTML::script('packages/datatables/js/fnReloadAjax.js')}}
	
	
	


    @yield('scripts')
    
    
    
    
    	<!-- Javascripts -->


 <script type="text/javascript">

 



 //Back to Table and Refresh Data
 $(document).ready(function(){





	 $('.close_popup').click(function(){



	

	 parent.oTable.fnReloadAjax(null,null,true);
	 parent.jQuery.fn.colorbox.close();
	 return false;

	})


	});
	

	
</script>

</body>
</html>












