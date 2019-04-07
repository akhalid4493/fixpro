@extends('admin._layouts.master')
@section('title','تعديل بيانات الباقة')
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
        <li><span>تعديل بيانات الباقة</span></li>
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
                تعديل بيانات منطقة : <b style="color: red">{{ $package->name_ar }}</b>
              </span>
            </div>
          </div>
          <div class="portlet-body form">
            <form id="updateForm" method="post" action="{{url(route('packages.update',$package->id))}}" class="form-horizontal form-row-seperated">
              
              {{ csrf_field() }}
              
              <input name="_method" type="hidden" value="PUT">
              
              <div class="form-body">
                
                <div class="form-group">
                  <label class="control-label col-md-3">
                    سعر الباقة
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-9">
                    <input type="text" name="price" placeholder="25.00" class="form-control" value="{{ $package->price }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">
                    عدد الشهور للباقة
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-9">
                    <input type="text" name="months" placeholder="12" class="form-control" value="{{ $package->months }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">
                    اسم الباقة [ar]
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-9">
                    <input type="text" name="name_ar" placeholder="ذهبي" class="form-control" value="{{ $package->name_ar }}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">
                    اسم الباقة [en]
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-9">
                    <input type="text" name="name_en" placeholder="Gold" class="form-control" value="{{ $package->name_en }}">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3">
                    وصف الباقة [ar]
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-9">
                    <textarea name="description_ar" class="form-control" id="" cols="30" rows="10">{!!$package->description_ar !!}</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">
                    وصف الباقة [en]
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-9">
                    <textarea name="description_en" id="" cols="30" rows="10" class="form-control">{!!$package->description_en !!}</textarea>
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
                        <input type="radio" name="status" value="1"
                        @if ($package->status == 1) checked="true" @endif>
                        <span></span>
                      </label>
                      <label class="mt-radio mt-radio-outline"> غير مفعل
                        <input type="radio" name="status" value="0"
                        @if ($package->status == 0) checked="true" @endif>
                        <span></span>
                      </label>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-md-3">
                    العلامة التجارية
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-9">
                    <select name="user_id" id="single" class="form-control select2" >
                      <option></option>
                      @foreach ($users as $user)
                      <option value="{{$user->id}}"
                        @if ($user->id == $package->user_id)
                        selected
                        @endif>
                        {{ $user->name }}
                      </option>
                      @endforeach
                    </select>
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
                    تعديل
                    </button>
                    <a href="{{url(route('packages.index')) }}" class="btn btn-lg red">
                      الخلف
                    </a>
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