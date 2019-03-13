@extends('admin._layouts.master')
@section('title','اضافة قطعة استهلاكية جديدة')
@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="{{ url(route('products.index')) }}">
						جميع القطع الاستهلاكيةات
					</a>
					<i class="fa fa-circle"></i>
				</li>
				<li><span>اضافة قطعة استهلاكية جديدة</span></li>
			</ul>
		</div>
		<h1 class="page-title"></h1>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered form-fit">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-equalizer font-green-haze"></i>
							<span class="caption-subject font-green-haze bold uppercase">
								اضافة قطعة استهلاكية جديدة
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form id="form" method="POST" action="{{url(route('products.store'))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated">
							
							{{ csrf_field() }}
							<div class="portlet-body">
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
														عنوان القطعة استهلاكية ar
														<span class="required">*</span>
													</label>
													<div class="col-md-9">
														<input type="text" name="name_ar" placeholder="باب خشب" class="form-control">
													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3">
														عنوان القطعة استهلاكية en
														<span class="required">*</span>
													</label>
													<div class="col-md-9">
														<input type="text" name="name_en" placeholder="Wood Door" class="form-control">
													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3">
														الكفالة بالشهور
														<span class="required">*</span>
													</label>
													<div class="col-md-9">
														<input type="text" name="warranty" placeholder="6" class="form-control">
													</div>
												</div>

												<div class="form-group">
													<label class="control-label col-md-3">
														سعر القطعة استهلاكية
														<span class="required">*</span>
													</label>
													<div class="col-md-9">
														<input type="text" name="price" placeholder="25.000" class="form-control">
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
															صورة القطعة استهلاكية
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
													<a href="{{url(route('products.index')) }}" class="btn btn-lg red">
														الخلف
													</a>
												</div>
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