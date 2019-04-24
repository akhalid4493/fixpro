@extends('admin._layouts.master')
@section('title','اضافة اشتراك جديدة')
@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="{{ url(route('subscriptions.index')) }}">جميع الباقات</a><i class="fa fa-circle"></i>
				</li>
				<li><span>اضافة اشتراك جديدة</span></li>
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
								اضافة اشتراك جديدة
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form id="form" method="POST" action="{{url(route('subscriptions.store'))}}" enctype="multipart/form-data" class="form-row-seperated">
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
											
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															باقات الاشتراك
															<span class="required">*</span>
														</label>
														<select name="package_id" id="single" class="form-control select2" >
															<option></option>
															@foreach ($packages as $package)
															<option value="{{$package->id}}">
																{{transText($package,'name')}}
															</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															اختر العضو
															<span class="required">*</span>
														</label>
														<select name="user_id" id="single" class="form-control select2" >
															<option></option>
															@foreach ($users as $user)
															<option value="{{$user->id}}">
																{{$user->name}}
															</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															السعر الكلي للاشتراك
															<span class="required">*</span>
														</label>
														<input type="text" class="form-control" name="total">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															التفعيل
															<span class="required">*</span>
														</label><br>
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
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">
															يبدا الاشتراك
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
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">
															ينتهي الاشتراك
															<span class="required">*</span>
														</label>
														<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
															<input type="text" class="form-control" name="end_at">
															<span class="input-group-btn">
																<button class="btn default" type="button">
																<i class="fa fa-calendar"></i>
																</button>
															</span>
														</div>
													</div>
												</div>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">
															الدفعة القادمة
														</label>
														<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
															<input type="text" class="form-control" name="next_billing">
															<span class="input-group-btn">
																<button class="btn default" type="button">
																<i class="fa fa-calendar"></i>
																</button>
															</span>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															ملاحطات
															<span class="required">*</span>
														</label>
														<textarea class="form-control" name="note" id="" cols="30" rows="10"></textarea>
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
											<button type="submit" id="submit" class="btn btn-lg blue">
											اضافة
											</button>
											<a href="{{url(route('subscriptions.index')) }}" class="btn btn-lg red">
												الخلف
											</a>
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