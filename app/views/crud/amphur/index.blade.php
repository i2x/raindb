@extends('protected.admin.master')

@section('title', 'CRUD - Ampur')

@section('content')

@if (Session::has('flash_message'))
			<p>{{ Session::get('flash_message') }}</p>
	@endif


	<ol class="breadcrumb">
  	<li><a href="{{URL::to('database')}}">Database</a></li>
  	<li class="active">Ampur</li>
	</ol>
	
	
	

			<div class="pull-right">
				<a href="{{{ URL::to('database/amphur/create') }}}" class="btn btn-small btn-info iframe">
				<span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
			<br>
		
	
	
	 <div class="page-header">
	
	
	</div>
	
			
						<table id="gridview" class="table table-striped table-hover table-condensed " >
						<thead>
						

								<tr>
									<th class="col-md-1">AMPHUR_ID</th>
									<th class="col-md-1">AMPHUR_CODE</th>
									<th class="col-md-1">AMPHUR_NAME</th>
									<th class="col-md-1">GEO_ID</th>
									<th class="col-md-1">PROVINCE_ID</th>
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

    {{ HTML::script('packages/datatables/js/jquery.dataTables.min.js')}}
	{{ HTML::script('packages/datatables/js/dataTables.bootstrap.js')}}
	{{ HTML::script('packages/colorbox/js/jquery.colorbox.js')}}
	{{ HTML::script('packages/datatables/js/fnReloadAjax.js')}}


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
		        "sAjaxSource": "{{ URL::to('database/amphur/data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           	$(".iframe").colorbox({iframe:true, transition:"none", width:"80%", height:"80%", escKey: false,
	           		    overlayClose: false});
	     		}
		
		    
			});

		});
	</script>
@endsection


	