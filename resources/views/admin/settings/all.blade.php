@extends('admin._layouts.master')
@section('title','الاعدادات  العامة')
@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="{{ url(route('admin')) }}">الرئيسية</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="#">الاعدادات  العامة</a>
				</li>
			</ul>
		</div>
		
		<h1 class="page-title"></h1>
		
		@include('admin._layouts._msg')
		<div class="row">
			<div class="profile-content">
				<div class="portlet light ">
					<form role="form" class="form-horizontal form-row-seperated" method="post" action="{{route('settings.store')}}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="portlet-body">
							<div class="portlet">
								<div class="portlet-body">
									<div class="tabbable-bordered">
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#global_setting" data-toggle="tab">
													اعدادات عامة
												</a>
											</li>
											<li>
												<a href="#contact_info" data-toggle="tab">
													تواصل معنا
												</a>
											</li>
											<li>
												<a href="#logo" data-toggle="tab">
													الشعار
												</a>
											</li>
											<li>
												<a href="#social" data-toggle="tab">
													التواصل الاجتماعي
												</a>
											</li>
										</ul>
										<div class="tab-content">
											@include('admin.settings.tabs')
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="margiv-top-10">
							<button type="submit" id="submit" class="btn green">حفظ التغيرات</button>
						</div>
					</form>
				</div>
			</div>
			
		</div>
	</div>
</div>
@stop