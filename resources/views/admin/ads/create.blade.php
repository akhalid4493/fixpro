@extends('admin._layouts.master')
@section('title','اضافة الاعلانات جديد')
@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="{{ url(route('ads.index')) }}">
						جميع الاعلانات
					</a>
					<i class="fa fa-circle"></i>
				</li>
				<li><span>اضافة الاعلانات جديد</span></li>
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
								اضافة الاعلانات جديد
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form id="form" method="POST" action="{{url(route('ads.store'))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated">
							@csrf
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
													عنوان الالاعلانات ar
													<span class="required">*</span>
												</label>
												<div class="col-md-9">
													<input type="text" name="name_ar" placeholder="" class="form-control">
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3">
													عنوان الالاعلانات en
													<span class="required">*</span>
												</label>
												<div class="col-md-9">
													<input type="text" name="name_en" placeholder="" class="form-control">
												</div>
											</div>

											<div class="form-group">
												<label class="control-label col-md-3">
													رابط الاعلان
													<span class="required">*</span>
												</label>
												<div class="col-md-9">
													<input type="text" name="link" placeholder="" class="form-control">
												</div>
											</div>

											<div class="form-group">
													<label class="control-label col-md-3">
			                        تاريخ البداية
			                        <span class="required">*</span>
			                    </label>
			                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
			                        <input type="text" class="form-control" name="start_at">
			                        <span class="input-group-btn">
			                            <button class="btn default" type="button">
			                            <i class="fa fa-calendar"></i>
			                            </button>
			                        </span>
			                    </div>
			                </div>

											<div class="form-group">
													<label class="control-label col-md-3">
			                        تاريخ النهاية
			                        <span class="required">*</span>
			                    </label>
			                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
			                        <input type="text" class="form-control" name="end_at" >
			                        <span class="input-group-btn">
			                            <button class="btn default" type="button">
			                            <i class="fa fa-calendar"></i>
			                            </button>
			                        </span>
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
														صورة الالاعلانات
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
												<a href="{{url(route('ads.index')) }}" class="btn btn-lg red">
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
