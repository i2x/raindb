
@extends('master')
@section('title', 'Log')

{{-- Content --}}
@section('content')

	<table id="gridview" class="table table-striped table-hover" >
	
		<thead>
			<tr>
				<th class="col-md-3">date</th>
				<th class="col-md-3">file name</th>
				<th class="col-md-1">url</th>
				<th class="col-md-1">message</th>
				<th class="col-md-1">level</th>
				<th class="col-md-2">detail</th>
				
				
		
				
				
			</tr>
		</thead>
	</table>


@stop


{{-- Style --}}

@section('style')
	
	{{ HTML::style('packages/datatables/css/dataTables.bootstrap.css')}}


@endsection

{{-- Scripts --}}
@section('scripts')



                
        
        
         

    {{ HTML::script('packages/datatables/js/jquery.dataTables.min.js')}}
	{{ HTML::script('packages/datatables/js/dataTables.bootstrap.js')}}
	
	
    

         
     
    


	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
			
			oTable = $('#gridview').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				
				"oLanguage": {
					"sLengthMenu": "_MENU_"
				},
				"bProcessing": true,
		        "bServerSide": true,
		        "iDisplayLength": 25,

		        "order": [[ 1, "desc" ]],
		        
		        
		        
		        
		        
		        "sAjaxSource": "{{ URL::to('log/data') }}",
		    
			});

		});
	</script>
@endsection

