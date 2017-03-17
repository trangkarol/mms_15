@extends('admin.block.main')
<!-- title off page -->
@section('title')
	{{trans('languages.title-admin')}}
@endsection
<!-- css used for page -->
@section('contentCss')

@endsection
<!-- content of page -->
@section('content')
	<div class="col-md-12 paddingtop">

		<div class="panel panel-default ">
			<div class="panel-heading">{{trans('languages.lbl-search')}}</div>
			    <div class="panel-body">
			    	<div class="table-responsive">
				        <table class="table table-borded table-striped">
				        	<thead>
				        		<tr>
				        			<th>STT</th>
				        			<th>Name</th>
				        		</tr>
				        	</thead>
				        	<tbody>
				        		<tr>
				        			<td>1</td>
				        			<td>Tran Van A</td>
				        		</tr>
				        		<tr>
				        			<td>2</td>
				        			<td>Tran Van B</td>
				        		</tr>
				        	</tbody>
				        </table>
				    </div>
			    </div>
			</div>
		</div>
@endsection	
<!-- js used for page -->
@section('contentJs')

@endsection
