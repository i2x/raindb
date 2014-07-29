@extends('master')

@section('title', 'Home')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="jumbotron">
                <h1> Laravel 4 Framework</h1>
                <p class="lead">This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content.
                 Use it as a starting point to create something more unique. </p>
                <p><a class="btn btn-lg btn-success" href="#" role="button">Lean more.</a></p>
            </div>
        </div>
    </div>

      <div class="zero-clipboard"><span class="btn-clipboard ">#1</span></div>
      
      <div class="bs-example">
      
           <p><span class="na"> Historical Data </span>เข้าไม่ได้ต้องแก้ชื่อคอลั่มจาก <code>`tbl_source.name` </code>  เป็น <code>`tbl_source.source_name` </code>  </p>

           <code> ALTER TABLE  `tbl_source` CHANGE  `name`  `source_name` VARCHAR( 45 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;  </code>

   	</div>
  	</div><!-- /.bs-example -->

@stop