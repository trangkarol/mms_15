@include('admin.block.header')
	<div class="container-fluid">
		<!-- menu -->
		@include('admin.block.menu')
		<!-- end menu -->
		<div class="container-fluid">
			<!-- container -->
			<div class="row">
				<!-- leftbar -->
				<div class="col-md-3">
					@include('admin.block.left_bar')
				</div>
				<!-- end left bar -->
				<!-- content -->
				<div class="col-md-9 content-right">
					<!-- button -->
					<div class="row">
						<div class="col-md-4 sub-menu">
							<h4>{{trans('languages.title-users')}}</h4>
						</div>
						<div class="col-md-8">
							<ul class="col-md-offset-10 col-md-5 paddingtop">
								<li class="col-md-2">
									<button type="button" class="btn btn-primary"><i class="fa fa-save " ></i></button>
								</li>
								<li class="col-md-2">
									<button type="button" class="btn btn-primary"><i class="fa fa-list " ></i></button>
								</li>
							</ul>
						</div>
					</div>
					<!-- content -->
					<div class="row">
						@yield('content')
					</div>
					
				</div>
				<!-- end contain -->
			</div>
			<!-- encontainer -->
		</div>
	</div>
@include('admin.block.footer')			