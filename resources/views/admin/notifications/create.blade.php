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
		@include('admin._layouts._msg')
		<h1 class="page-title"></h1>
		<div class="row">
			<div class="col-md-12">
				<div class="profile-content">
					<div class="portlet light">
						<form method="POST" action="{{url(route('notification.store'))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated">
							{{ csrf_field() }}
							<div class="portlet-body">
								<div class="portlet">
									<div class="tabbable-bordered">
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#global" data-toggle="tab">
													ارسال الاشعارات
												</a>
											</li>
										</ul>
										<div class="tab-content">
											<div class="form-group">
												<label class="control-label">
													عنوان الرسالة
													<span class="required">*</span>
												</label>
												<input type="text" name="title" placeholder="مثال : شاهد المنتجات الجديدة" class="form-control emojioneArea">
											</div>
											<div class="form-group">
												<label class="control-label">
													محتوى الرسالة
													<span class="required">*</span>
												</label>
												<textarea name="body" class="form-control emojioneArea" cols="30" rows="10"></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-9">
									<button type="submit" id="submit" class="btn btn-lg blue">
									ارسال
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
@stop