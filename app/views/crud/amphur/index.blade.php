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
	
	<div class="page-header">
	
	</div>
	
			
						<table id="gridview" class="table table-striped table-hover" >
						<thead>
						

								<tr>
									<th class="col-md-1">1</th>
									<th class="col-md-1">2</th>
									<th class="col-md-1">3</th>
									<th class="col-md-1">4</th>
									<th class="col-md-1">5</th>

								
								</tr>
							</thead>
						</table>

						
{{ Form::open(array('url' => 'import/upload','files' => true)) }}
<?php 

		echo Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Submit',
		 array('class' => 'btn btn-primary btn-sm','id' => 'submit','type'=>'submit'))

?>
		 <a href="{{ URL::previous() }}">
		 <button type="button" class="btn btn-danger">
			  <span class="glyphicon glyphicon-remove-circle"></span>
			 cancle
		 </button></a>
		 
</div>
{{ Form::close() }}

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
	           		$(".iframe").colorbox({iframe:true, transition:"none", width:"80%", height:"80%"});
	     		}
		
		    
			});

		});
	</script>
@endsection


	