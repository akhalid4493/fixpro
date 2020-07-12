@extends('admin._layouts.master')
@section('title','اضافة خدمة جديدة')
@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="{{ url(route('services.index')) }}">جميع الخدمات</a><i class="fa fa-circle"></i>
				</li>
				<li><span>اضافة خدمة جديدة</span></li>
			</ul>
		</div>
		<h1 class="page-title"></h1>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title tabbable-line">
						<div class="caption caption-md">
							<i class="icon-globe theme-font hide"></i>
							<span class="caption-subject font-blue-madison bold uppercase">
								اضافة خدمة جديدة
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form id="form" method="POST" action="{{url(route('services.store'))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated">

							{{ csrf_field() }}
							<div class="tabbable-bordered">
								<ul class="nav nav-tabs">
									<li class="active">
										<a href="#general" data-toggle="tab"> بيانات عامة </a>
									</li>
								</ul>
								<div class="tab-content">

									{{-- GENERAL CONTENT --}}
									<div class="tab-pane active" id="general">
										<div class="form-body">

											<div class="form-group">
												<label class="control-label col-md-3">
													عنوان الخدمة ar
													<span class="required">*</span>
												</label>
												<div class="col-md-9">
													<input type="text" name="name_ar" placeholder="تصليح كهرباء" class="form-control">
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3">
													عنوان الخدمة en
													<span class="required">*</span>
												</label>
												<div class="col-md-9">
													<input type="text" name="name_en" placeholder="electrical maintenance" class="form-control">
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3">
													سعر الخدمة
													<span class="required">*</span>
												</label>
												<div class="col-md-9">
													<input type="text" name="price" placeholder="3.000" class="form-control">
												</div>
											</div>


											<div class="form-group">
												<label class="control-label col-md-3">
													الاقسام
													<span class="required">*</span>
												</label>
												<div class="col-md-9">
													<select name="categories[]" id="single" class="form-control select2" multiple="">
														@foreach ($categories as $category)
														<option value="{{ $category['id'] }}">
															{{ $category['name_ar'] }}
														</option>
														@endforeach
													</select>
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3">
													الحالة
													<span class="required">*</span>
												</label>
												<div class="col-md-9">
													<div class="mt-radio-inline">
														<label class="mt-radio mt-radio-outline"> مفعل
															<input type="radio" name="status" value="1">
															<span></span>
														</label>
														<label class="mt-radio mt-radio-outline">
															غير مفعل
															<input type="radio" name="status" value="0">
															<span></span>
														</label>
													</div>
												</div>
											</div>

											<div class="form-body">
												<div class="form-group">
													<label class="control-label col-md-3">
														صورة الخدمة
													</label>
													<div class="col-md-9">
														<input class="form-control" type="file" name="image">
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="form-actions">
										<div id="result" style="display: none"></div>

										<div class="progress-info" style="display: none">
											<div class="progress">
												<span class="progress-bar progress-bar-warning"></span>
											</div>
											<div class="status" id="progress-status"></div>
										</div>

										<div class="form-group">
											<div class="col-md-offset-3 col-md-9">
												<button type="submit" id="submit" class="btn btn-lg blue">
													اضافة
												</button>
												<a href="{{url(route('services.index')) }}" class="btn btn-lg red">
													الخلف
												</a>
											</div>
										</div>
									</div>
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

@section('scripts')
<script>
	function disableMyText() {

		if (document.getElementById("main_page").checked == true) {

				document.getElementById("single").disabled = true;

		} else {

				document.getElementById("single").disabled = false;

		}

	}
</script>
@stop
