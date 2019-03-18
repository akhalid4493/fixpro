@extends('admin._layouts.master')
@section('title','تعديل بيانات العضو')
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
					<a href="{{ url(route('users.index')) }}">جميع الاعضاء</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="#">تعديل بيانات العضو</a>
				</li>
			</ul>
		</div>
		<h1 class="page-title"></h1>
		
		<div class="row">
			<div class="profile-content">
				<div class="portlet light ">
					<div class="portlet-title tabbable-line">
						<div class="caption caption-md">
							<i class="icon-globe theme-font hide"></i>
							<span class="caption-subject font-blue-madison bold uppercase">
								تعديل بيانات العضو : {{ $user['name'] }}
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form id="updateForm" action="{{url(route('users.update',$user->id))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated"
							method="POST">
				        	@method('PUT')
							@csrf
							<div class="portlet">
								<div class="portlet-body">
									<div class="tabbable-bordered">
										<ul class="nav nav-tabs">
											<li class="active">
												<a href="#tab_general" data-toggle="tab">
													بيانات عامة
												</a>
											</li>
										</ul>
										{{-- FORM BODY --}}
										<div class="tab-content">
											<div class="tab-pane active" id="tab_general">
												<div class="form-group">
													<label class="control-label col-md-2">
														اسم العضو
														<span class="required">*</span>
													</label>
													<div class="col-md-9">
														<input type="text" name="name" placeholder="Amr Khaled" class="form-control" value="{{ $user['name'] }}">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-2">
														البريد الالكتروني
														<span class="required">*</span>
													</label>
													<div class="col-md-9">
														<input type="email" name="email" placeholder="email@exmaple.com" class="form-control" value="{{ $user['email'] }}">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-2">
														رقم الهاتف
														<span class="required">*</span>
													</label>
													<div class="col-md-9">
														<input type="mobile" name="mobile" placeholder="55050505" class="form-control" value="{{ $user['mobile'] }}">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-2">
														كلمة المرور
													</label>
													<div class="col-md-9">
														<input type="password" name="password" class="form-control" placeholder="كتابة كلمة المرور : [A-Z & 0-9]">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-2">
														تآكيد كلمة المرور
													</label>
													<div class="col-md-9">
														<input type="password" name="password_confirmation" class="form-control" placeholder="تآكيد كلمة المرور">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-2">
														التفعيل
														<span class="required">*</span>
													</label>
													<div class="col-md-9">
														<div class="mt-radio-inline">
															<label class="mt-radio mt-radio-outline"> مفعل
																<input type="radio" name="active" value="1"
																@if ($user->active == 1) checked="true" @endif>
																<span></span>
															</label>
															<label class="mt-radio mt-radio-outline">
																غير مفعل
																<input type="radio" name="active" value="0"
																@if ($user->active == 0) checked="true" @endif>
																<span></span>
															</label>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-2">
														تحديد الصلاحيات
													</label>
													<div class="col-md-9">
														<div class="mt-checkbox-list">
															@foreach ($roles as $role)
															<label class="mt-checkbox">
																<input type="checkbox" name="roles[]" value="{{$role->id}}" 
																@if ($user->roles->contains($role->id))
																	checked="" 
																@endif>
																{{$role->display_name}}
																<span></span>
															</label>
															@endforeach
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-md-2">
														الصورة الشخصية
													</label>
													<div class="col-md-9">
														<input class="form-control" type="file" name="image">
															<img src="{{url($user->image)}}" class="img-thumbnail" style="width:15%">
													</div>
												</div>
											</div>
											
											{{-- ACTION FORM & RESPONSE --}}
											<div class="form-actions">
												<div id="result" style="display: none"></div>
												
												<div class="progress-info" style="display: none">
													<div class="progress">
														<span class="progress-bar progress-bar-warning"></span>
													</div>
													<div class="status" id="progress-status"></div>
												</div>
												
												<div class="form-group">
													<div class="col-md-offset-2 col-md-9">
														<button type="submit" id="submit" class="btn btn-lg blue">
														اضافة
														</button>
														<a href="{{url(route('users.index')) }}" class="btn btn-lg red">
															الخلف
														</a>
													</div>
												</div>
											</div>
											{{-- END ACTION FORM & RESPONSE --}}
										</div>
										{{-- END FORM BODY --}}
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