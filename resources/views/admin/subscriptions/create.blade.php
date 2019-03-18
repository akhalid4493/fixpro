@extends('admin._layouts.master')
@section('title','اضافة قسم جديدة')
@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
				</li>
				<li>
					<a href="{{ url(route('categories.index')) }}">جميع الصفحات</a><i class="fa fa-circle"></i>
				</li>
				<li><span>اضافج قسم جديدة</span></li>
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
											اضافة قسم جديدة
										</span>
									</div>
									<ul class="nav nav-tabs">
										<li class="active">
											<a href="#tab_1_1" data-toggle="tab" aria-expanded="true">
												محتوى القسم
											</a>
										</li>
									</ul>
								</div>
								<div class="portlet-body form">
									<form id="form" method="POST" action="{{url(route('categories.store'))}}" enctype="multipart/form-data">
										
										{{ csrf_field() }}
										<div class="tab-content">
											
											<div class="tab-pane active" id="tab_1_1">
												<div class="form-group">
													<label class="control-label">
														عنوان القسم بالعربي
														<span class="required">*</span>
													</label>
													<input type="text" name="name_ar" placeholder="مثال : الشروط و الاحكام" class="form-control">
												</div>
												<div class="form-group">
													<label class="control-label">
														عنوان القسم بالانجليزي
														<span class="required">*</span>
													</label>
													<input type="text" name="name_en" placeholder="مثال : Terms and Conditions" class="form-control">
												</div>
												<div class="form-group form-md-radios">
													<label>مستوى القسم</label>
													<div class="md-radio-list">
														<div class="md-radio">
															<input type="radio" id="radio0" name="category_id" class="md-radiobtn" value="">
															<label for="radio0">
																<span class="inc"></span>
																<span class="check"></span>
																<span class="box"></span> مستوى رئيسي
															</label>
														</div>
														@if (count($categories) > 0)
														<label style="font-size: 14px;color: #888;opacity: 1;">قسم فرعي من :</label>
														<div class="form-group">
															<select name="category_id" id="single" class="form-control select2" >
																<option></option>
																@foreach ($categories as$category)
																<option value="{{$category->id}}">
																	{{transText($category,'name')}}
																</option>
																@endforeach
															</select>
														</div>
														@endif
													</div>
												</div>
												<div class="form-body">
													<div class="form-group">
														<label>
															صورة القسم
															<span class="required">*</span>
														</label>
														<input class="form-control" type="file" name="image">
													</div>
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
										<a href="{{url(route('categories.index'))}}" class="btn-lg btn red">
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
</div>
</div>
@stop