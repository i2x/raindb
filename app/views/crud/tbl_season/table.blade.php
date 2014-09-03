@extends('protected.admin.master')

@section('title', 'CRUD - Ampur')

@section('content')

@if (Session::has('flash_message'))
			<p>{{ Session::get('flash_message') }}</p>
	@endif


	<ol class="breadcrumb">
  	<li><a href="{{URL::to('database')}}">Database</a></li>
  	<li class="active">season</li>
	</ol>
	
	
	

			<div class="pull-right">
				<a href="{{{ URL::to('database/tbl_season/create') }}}" class="btn btn-small btn-info iframe">
				<span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
			<br>
		
	
	
	 <div class="page-header">
	
	
	</div>
	
			
						<table id="gridview" class="table table-striped table-hover table-condensed " >
						<thead>
						
								<tr>
									<th class="col-md-1">id</th>
									<th class="col-md-1">season</th>
									<th class="col-md-1"> </th>
									
						

								
								</tr>
							</thead>
						</table>

		
 

@endsection



{{-- Style --}}

@section('style')
	
	{{ HTML::style('packages/datatables/css/dataTables.bootstrap.css')}}
	{{ HTML::style('packages/colorbox/css/colorbox.css')}}
	


@endsection

{{-- Scripts --}}
@section('scripts')


	{{ HTML::script('packages/jquery/jquery.min.js'); }}
	{{ HTML::script('packages/bootstrap/js/bootstrap.min.js'); }}
    {{ HTML::script('packages/datatables/js/jquery.dataTables.min.js')}}
	{{ HTML::script('packages/datatables/js/dataTables.bootstrap.js')}}
	{{ HTML::script('packages/colorbox/js/jquery.colorbox.js')}}
	{{ HTML::script('packages/datatables/js/fnReloadAjax.js')}}
	{{ HTML::script('packages/bootbox/bootbox.min.js')}}
	


	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
			
			oTable = $('#gridview').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
								},
				"bProcessing": true,
		        "bServerSide": true,
		        "iDisplayLength": 25,
		        "sAjaxSource": "{{ URL::to('database/tbl_season/data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           	$(".iframe").colorbox({iframe:true, transition:"none", width:"80%", height:"80%", escKey: false,
	           		    overlayClose: false});
	     		}
			});

		});
		function Delete(id) {
			bootbox.confirm("The <code> AMPHUR ID "+id+" </code>will be deleted immediately. Are you sure you want to continue?", 
			function(result) {
				if(result){
					 $.ajax( 
							 {

							    url: 'tbl_season/'+id+'/delete',
							    type: 'POST',
							    success: function(result) {
							   	 	parent.oTable.fnReloadAjax(null,null,true);
							    }
							  });
					  }}); 
			  }
		  </script>
@endsection


	