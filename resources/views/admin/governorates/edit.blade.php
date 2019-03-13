@extends('admin._layouts.master')
@section('title','تعديل بيانات المحافظة')
@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="{{ url(route('governorates.index')) }}">جميع الاقسام</a><i class="fa fa-circle"></i>
        </li>
        <li><span>تعديل بيانات المحافظة</span></li>
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
                تعديل بيانات محافظة : <b style="color: red">{{ $governorate->name_ar }}</b>
              </span>
            </div>
          </div>
          <div class="portlet-body form">
            <form id="updateForm" method="post" action="{{url(route('governorates.update',$governorate->id))}}" class="form-horizontal form-row-seperated">
              
              {{ csrf_field() }}
              
              <input name="_method" type="hidden" value="PUT">
              
              <div class="form-body">
                
                <div class="form-group">
                  <label class="control-label col-md-3">
                    اسم المحافظة [ar]
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-9">
                    <input type="text" name="name_ar" value="{{ $governorate->name_ar }}" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">
                    اسم المحافظة [en]
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-9">
                    <input type="text" name="name_en" value="{{ $governorate->name_en }}" class="form-control">
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
                        @if ($governorate->status == 1) checked="true" @endif>
                        <span></span>
                      </label>
                      <label class="mt-radio mt-radio-outline"> غير مفعل
                        <input type="radio" name="status" value="0"
                        @if ($governorate->status == 0) checked="true" @endif>
                        <span></span>
                      </label>
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
                    <a href="{{url(route('governorates.index')) }}" class="btn btn-lg red">
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