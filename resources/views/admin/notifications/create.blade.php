@extends('admin._layouts.master')
@section('title','اضافة اشعارات عامة للمستخدمين')
@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
				</li>
				<li><span>اضافة اشعارات عامة للمستخدمين</span></li>
			</ul>
		</div>

		@include('admin._includes.msg')

		<h1 class="page-title"></h1>
		<div class="row">
			<div class="col-md-12">
				<div class="profile-content">
					<div class="row">
						<div class="col-md-12">
							<div class="portlet light ">
								<div class="portlet-title tabbable-line">
									<div class="caption caption-md">
										<i class="icon-globe theme-font hide"></i>
										<span class="caption-subject font-blue-madison bold uppercase">
											اضافة اشعارات عامة للمستخدمين
										</span>
									</div>
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#tab_1_1" data-toggle="tab" aria-expanded="true">
												محتوى ااشعارات عامة
											</a>
										</li>
									</ul>
								</div>
								<div class="portlet-body">
									<form method="POST" action="{{url(route('notify'))}}" enctype="multipart/form-data">
										
										{{ csrf_field() }}
										<div class="tab-content">
											
											<div class="tab-pane active" id="tab_1_1">
												<div class="form-group">
													<label class="control-label">
														عنوان الرسالة
														<span class="required">*</span>
													</label>
													<input type="text" name="title" placeholder="مثال : شاهد المنتجات الجديدة" class="form-control">
												</div>

												<div class="form-group">
													<label class="control-label">
														محتوى الرسالة
														<span class="required">*</span>
													</label>
													<textarea name="body" class="form-control" cols="30" rows="10"></textarea>
												</div>
											</div>
										</div>
									</div>
									
									<div id="result" style="display: none"></div>
									
									<div class="progress-info" style="display: none">
										<div class="progress">
											<span class="progress-bar progress-bar-warning"></span>
										</div>
										<div class="status" id="progress-status"></div>
									</div>
									<div class="form-group">
										<button type="submit" id="submit" class="btn-lg btn blue">
										اضافة
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
@stop