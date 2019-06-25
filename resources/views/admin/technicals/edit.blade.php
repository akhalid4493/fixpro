@extends('admin._layouts.master')
@section('title','تعديل بيانات الموظف ( فني )')
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
					<a href="{{ url(route('technicals.index')) }}">جميع الموظفين</a>
					<i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="#">تعديل بيانات الموظف ( فني )</a>
				</li>
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
								تعديل بيانات الموظف ( فني ) : {{ $user['name'] }}
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form id="updateForm" action="{{url(route('technicals.update',$user->id))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated"
							method="POST">
							@method('PUT')
							@csrf
							<div class="portlet">
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
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															يبدا دوام الموظف في
															<span class="required">*</span>
														</label>
														<div class="input-group">
															<input autocomplete="off" type="text" class="form-control timepicker timepicker-no-seconds" name="from" @if ($user->shift)
															value="{{ date('H:i:s', strtotime($user->shift->from)) }}"
															@endif>
															<span class="input-group-btn">
																<button class="btn default"type="button">
																<i class="fa fa-clock-o"></i>
																</button>
															</span>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															ينتهي دوام الموظف الى
															<span class="required">*</span>
														</label>
														<div class="input-group">
															<input autocomplete="off" type="text" class="form-control timepicker timepicker-no-seconds" name="to"
															@if ($user->shift)
															value="{{ date('H:i:s', strtotime($user->shift->to)) }}"
															@endif>
															<span class="input-group-btn">
																<button class="btn default" type="button">
																<i class="fa fa-clock-o"></i>
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
															ايام العمل الرسمية
															<span class="required">*</span>
														</label>
														<select name="days[]" id="single" class="form-control select2-multiple" multiple>
															@for ($i = 1; $i <= 7; $i++)
															<option value="{{ dayName($i) }}"
																@foreach ($user->workDays as $day)
																@if ($day->day == dayName($i))
																selected=""
																@endif
																@endforeach>
																{{ dayName($i) }}
															</option>
															@endfor
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															المناطق التي يخدمها
															<span class="required">*</span>
														</label>
														<select name="governorates[]" id="single" class="form-control select2" multiple>
															<option value=""></option>
															@foreach ($governorates as $governorate)
															<option value="{{$governorate->id}}"
																@if ($user->locationsOfTechnical->contains($governorate->id))
																selected=""
																@endif>
																{{ $governorate['name_ar'] }}
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
															الخدمات التي يعمل بها
															<span class="required">*</span>
														</label>
														<select name="services" id="single" class="form-control select2">
															<option value=""></option>
															@foreach ($services as $service)
															<option value="{{$service->id}}"
																@if ($user->servicesOfTechnical->contains($service->id))
																selected=""
																@endif>
																{{ $service['name_ar'] }}
															</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">
															الاقسام المتاحة للفني
															<span class="required">*</span>
														</label>
														<select name="categories[]" id="single" class="form-control select2" multiple>
															<option value=""></option>
															@foreach ($categories as $category)
															<option value="{{$category->id}}"
																@if ($user->categoriesOfTechnical->contains($category->id))
																selected=""
																@endif>
																{{ $category['name_ar'] }}
															</option>
															@endforeach
														</select>
													</div>
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
													تعديل
													</button>
													<a href="{{url(route('technicals.index')) }}" class="btn btn-lg red">
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
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
