@extends('master')
@section('title', 'Refresh NCEP data')


@section('content')


<p>Click the button below to update/import NCEP data.</p>
<p>This may take up to 5-10 minutes.</p>
{{ Form::open(array('url' => 'refrefresh' ,'method' => 'POST')) }}

<button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Update NCEP Data</button>



{{ Form::close() }}
<br/>
<div>
@if(isset($message))
    {{$message}} <br/>  
@endif
@if(isset($message))
   
    <p>Udate Summary</p>
	<table id="gridview" class="table table-striped table-hover table-condensed" >
	
		<thead>
			<tr>
				<th class="col-md-1">Basin</th>
				<th class="col-md-1">Season</th>
				<th class="col-md-1">Parameter Name</th>
				<th class="col-md-1">From Year</th>
				<th class="col-md-1">To Year</th>
			</tr>
		</thead>
	</table>    
@endif
</div>
@stop

{{-- Style --}}

@section('style')
	
	{{ HTML::style('packages/chosen/chosen.min.css')}}
	{{ HTML::style('packages/datatables/css/dataTables.bootstrap.css')}}
	


@endsection

{{-- Scripts --}}
@section('scripts')

	
	

	{{ HTML::script('packages/jquery/jquery.min.js'); }}
	{{ HTML::script('packages/chosen/chosen.jquery.min.js')}}
	{{ HTML::script('packages/highcharts/js/highcharts.js')}}
	{{ HTML::script('packages/highcharts/js/modules/exporting.js')}}
   	{{ HTML::script('packages/datatables/js/jquery.dataTables.min.js')}}
	{{ HTML::script('packages/datatables/js/dataTables.bootstrap.js')}}
	
	
	{{ HTML::script('packages/datepicker/js/bootstrap-datepicker.js')}}
	{{ HTML::style('packages/datepicker/css/datepicker3.css')}}		
	
	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
			oTable = $('#gridview').dataTable( {

				
				"oLanguage": {
					"sLengthMenu": "_MENU_"
				},
				"bProcessing": true,
		        "bServerSide": true,
		        "iDisplayLength": 100,
				"sAjaxSource": "{{ URL::to('refrefresh/data') }}",
			
		    
			});

		});
	</script>
@stop