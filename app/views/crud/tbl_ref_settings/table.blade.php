@extends('protected.admin.master')

@section('title', 'CRUD - Ampur')

@section('content')

@if (Session::has('flash_message'))
			<p>{{ Session::get('flash_message') }}</p>
	@endif


	<ol class="breadcrumb">
  	<li><a href="{{URL::to('database')}}">Database</a></li>
  	<li class="active">tbl_ref_settings</li>
	</ol>
	
	
	

			<div class="pull-right">
				<a href="{{{ URL::to('database/tbl_ref_settings/create') }}}" class="btn btn-small btn-info iframe">
				<span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
			<br>
		
	
	
	 <div class="page-header">
	
	
	</div>
	
			
						<table id="gridview" class="table table-striped table-hover table-condensed " >
						<thead>
					
								<tr>
									<th class="col-md-1">idtbl_ref_settings</th>
									<th class="col-md-1">basin_id</th>
									<th class="col-md-1">reftype</th>
									<th class="col-md-1">varname</th>
									<th class="col-md-1">analysis_level</th>
									<th class="col-md-1">latitude_from</th>
									<th class="col-md-1">latitude_to</th>
									<th class="col-md-1">longtitude_from</th>
									<th class="col-md-1">longtitude_to</th>
									<th class="col-md-1">time_scale</th>
									<th class="col-md-1">month_from</th>
									<th class="col-md-1">month_to</th>
									<th class="col-md-1">area_weight_grid</th>
									<th class="col-md-1">source_url</th>
									
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
		        "sAjaxSource": "{{ URL::to('database/tbl_ref_settings/data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           	$(".iframe").colorbox({iframe:true, transition:"none", width:"80%", height:"80%", escKey: false,
	           		    overlayClose: false});
	     		}
			});

		});
		function Delete(id) {
			bootbox.confirm("<code>idtbl_ref_settings "+id+" </code>will be deleted immediately. Are you sure you want to continue?", 
			function(result) {
				if(result){
					 $.ajax( 
							 {

							    url: 'tbl_ref_settings/'+id+'/delete',
							    type: 'POST',
							    success: function(result) {
							   	 	parent.oTable.fnReloadAjax(null,null,true);
							    }
							  });
					  }}); 
			  }
		  </script>
@endsection


	