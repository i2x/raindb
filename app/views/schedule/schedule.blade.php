@extends('protected.admin.master')
@section('title', 'schedule  ')


@section('content')


	<table id="gridview" class="table table-striped table-hover" >
	
		<thead>
			<tr>
				<th class="col-md-3">Files waiting to be uploaded</th>				
			</tr>
		</thead>
                		<tfoot>
			<tr>
				<th class="col-md-3">Files waiting to be uploaded</th>				
			</tr>
		</tfoot>
                <tbody>
                <?php 
                    foreach($files as $file){
                        echo "<tr><td>".$file['file_name']."</td></tr>";
                    }
                ?>
                </tbody>
	</table>





{{ Form::open(array('url' => 'schedule' ,'method' => 'POST')) }}

<button class="btn btn-primary"><span class="glyphicon glyphicon-check"></span> Upload Now</button>



{{ Form::close() }}

@stop

<script type="text/javascript">
$(document).ready(function() {
    $('#gridview').dataTable();
} );
</script>