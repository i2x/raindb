@extends('master')
@section('title', 'Preview')

@section('content')

	<ol class="breadcrumb">
  	<li><a href="#">Home</a></li>
  	<li><a href="#">Import</a></li>
  	<li class="active">Preview</li>
	</ol>
	
	<div class="page-header">
	{{$fileName}}
	
	</div>
	
	
		<ul class="nav nav-tabs" id="Tab_" >
	  	<li class="active"><a href="#Data" data-toggle="tab">Preview</a></li>
  		<li ><a href="#Missing" data-toggle="tab">Missing</a></li>

		</ul>

		<div class="tab-content">
  				
  				
  				<div class="tab-pane fade in active" id="Data" >
				<!-- Preview Tabs -->  		
						<br><br>				
						<table id="gridview" class="table table-striped table-hover" >
						<thead>
						

								<tr>
									<th class="col-md-1">meas_id</th>
									<th class="col-md-3">meas_date</th>
									<th class="col-md-1">station_id</th>
									<th class="col-md-3">name</th>
									<th class="col-md-1">max_temp</th>
									<th class="col-md-1">min_temp</th>
									<th class="col-md-1">rain</th>
									<th class="col-md-1">avgrh</th>
									<th class="col-md-1">evapor</th>
									<th class="col-md-1">mean_temp</th>
									<th class="col-md-1">source_name</th>

								
								</tr>
							</thead>
						</table>

				</div>
  				
  				
  				<div class="tab-pane fade " id="Missing">
  				 <!-- Missing Tabs --> 
  				 	<br><br>
  				 	<table id="gridview" class="table table-striped table-hover" >
							<thead>
									<tr>
										<th class="col-md-2">meas_id</th>
										<th class="col-md-3">meas_date</th>
										<th class="col-md-2">station_id</th>
										<th class="col-md-2">max_temp</th>
										<th class="col-md-2">min_temp</th>
										<th class="col-md-2">rain</th>
										<th class="col-md-2">avgrh</th>
										<th class="col-md-2">mean_temp</th>
										<th class="col-md-2">source</th>
									
									
									</tr>
								</thead>
							</table>
  				</div>
		</div>
		

	


{{ Form::open(array('url' => 'import/upload','files' => true)) }}
<?php 

		echo Form::button('<i class="glyphicon glyphicon-ok-sign"></i> Submit',
		 array('class' => 'btn btn-info btn-sm','id' => 'submit','type'=>'submit'))

?>
		 <a href="{{ URL::previous() }}">
		 <button type="button" class="btn btn-sm btn-danger iframe">
			  <span class="glyphicon glyphicon-remove-circle"></span>
			 cancle
		 </button></a>
		 
</div>

<br><br>
<br>
<br>

{{ Form::close() }}






	
@endsection



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
		        
		        
		        
		        
		        
		        "sAjaxSource": "{{ URL::to('import/data') }}",
		    
			});

		});
	</script>
@endsection


	