@extends('admin._layouts.master')
@section('title','اضافة باقة جديدة')
@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="{{ url(route('packages.index')) }}">جميع الباقات</a><i class="fa fa-circle"></i>
				</li>
				<li><span>اضافة باقة جديدة</span></li>
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
								اضافة باقة جديدة
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form id="form" method="POST" action="{{url(route('packages.store'))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated">
							
							{{ csrf_field() }}
							
							<div class="form-body">
								
								<div class="form-group">
									<label class="control-label col-md-3">
										سعر الباقة
										<span class="required">*</span>
									</label>
									<div class="col-md-9">
										<input type="text" name="price" placeholder="25.00" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-3">
										عدد الشهور للباقة
										<span class="required">*</span>
									</label>
									<div class="col-md-9">
										<input type="text" name="months" placeholder="12" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-3">
										اسم الباقة [ar]
										<span class="required">*</span>
									</label>
									<div class="col-md-9">
										<input type="text" name="name_ar" placeholder="ذهبي" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">
										اسم الباقة [en]
										<span class="required">*</span>
									</label>
									<div class="col-md-9">
										<input type="text" name="name_en" placeholder="Gold" class="form-control">
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-3">
										وصف الباقة [ar]
										<span class="required">*</span>
									</label>
									<div class="col-md-9">
										<textarea name="description_ar" class="form-control" id="" cols="30" rows="10"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">
										وصف الباقة [en]
										<span class="required">*</span>
									</label>
									<div class="col-md-9">
										<textarea name="description_en" id="" cols="30" rows="10" class="form-control"></textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-3">
										العميل
										<span class="required">*</span>
									</label>
									<div class="col-md-9">
										<select name="user_id" id="single" class="form-control select2" >
											<option></option>
											@foreach ($users as $user)
											<option value="{{$user->id}}">
												{{ $user->name }}
											</option>
											@endforeach
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="control-label col-md-3">
										التفعيل
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
											<a href="{{url(route('packages.index')) }}" class="btn btn-lg red">
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