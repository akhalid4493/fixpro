@extends('admin._layouts.master')
@section('title','اضافة معاينة جديدة')
@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="{{ url(route('previews.index')) }}">جميع المعاينات</a><i class="fa fa-circle"></i>
				</li>
				<li><span>اضافج معاينة جديدة</span></li>
			</ul>
		</div>
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
											اضافة معاينة جديدة
										</span>
									</div>
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#tab_1_1" data-toggle="tab" aria-expanded="true">
												محتوى المعاينة
											</a>
										</li>
									</ul>
								</div>
								<div class="portlet-body form">
									<form id="form" method="POST" action="{{url(route('previews.store'))}}" enctype="multipart/form-data">

										{{ csrf_field() }}
										<div class="tab-content">

											<div class="tab-pane active" id="tab_1_1">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																موعد طلب المعاينة
																<span class="required">*</span>
															</label>
															<div class="input-group">
																<input autocomplete="off" type="text" class="form-control timepicker timepicker-24" name="time" autocomplete="off">
																<span class="input-group-btn">
																	<button class="btn default" type="button">
																		<i class="fa fa-clock-o"></i>
																	</button>
																</span>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="control-label">
																تاريخ طلب المعاينة
																<span class="required">*</span>
															</label>
															<div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
																<input type="text" class="form-control" name="date" autocomplete="off">
																<span class="input-group-btn">
																	<button class="btn default" type="button">
																		<i class="fa fa-calendar"></i>
																	</button>
																</span>
															</div>
														</div>
													</div>
												</div>

												<div class="form-group">
													<label class="control-label">
														الخدمة المطلوبة
														<span class="required">*</span>
													</label>
													<select name="service_id[]" id="single" class="form-control select2">
														<option></option>
														@foreach ($services as $service)
														<option value="{{$service->id}}">
															{{ $service->name_ar }}
														</option>
														@endforeach
													</select>
												</div>

												<div class="form-group">
													<label class="control-label">
														المستخدم
														<span class="required">*</span>
													</label>
													<select name="user_id" id="single" class="form-control select2 selectUser">
														<option></option>
														@foreach ($users as $user)
														<option value="{{$user->id}}">
															{{ $user->name . ' - ' . $user->mobile}}
														</option>
														@endforeach
													</select>
												</div>

												<div class="values"></div>

												<div class="form-group">
													<label class="control-label">
														ملاحظات المستخدم
														<span class="required">*</span>
													</label>
													<textarea name="note" class="form-control" rows="8" cols="80"></textarea>
												</div>

												<div class="form-group">
													<label class="control-label">
														ملاحظات المدير
														<span class="required">*</span>
													</label>
													<textarea name="note_from_admin" class="form-control" rows="8" cols="80"></textarea>
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
									<a href="{{url(route('previews.index'))}}" class="btn-lg btn red">
										للخلف
									</a>
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
@stop

@section('scripts')
	<script type="text/javascript">

	$('.selectUser').change(function(event){
			var user_id = $('.selectUser').val();

			$.ajax({
					type: 'GET',
					url: '{{url(route('previews.user.addresses'))}}',
					data: {
						id : user_id
					},
					dataType: 'html',
					encode: true
			})
			.done(function(msg) {
				$('select').select2('destroy');
				$(".values").html(msg);
				$('select').select2();
			})
			.fail(function(data) {
					alert('please select the attribute');
			})
			event.preventDefault();

	});
	</script>
@stop
