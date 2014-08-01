
    
    {{ HTML::script('packages/jquery/jquery.min.js'); }}
    {{ HTML::script('packages/datatables/js/jquery.dataTables.min.js')}}
	{{ HTML::script('packages/datatables/js/dataTables.bootstrap.js')}}
	{{ HTML::script('packages/colorbox/js/jquery.colorbox.js')}}
	{{ HTML::script('packages/datatables/js/fnReloadAjax.js')}}
	

	
	

<script type="text/javascript">

//Back to Table and Refresh Data
$(document).ready(function(){
	
	 parent.jQuery.fn.colorbox.close();
	 parent.oTable.fnReloadAjax();
	 return false;




});



	</script>