@extends('admin._layouts.master')
@section('title','تعديل بيانات المنطقة')
@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="{{ url(route('provinces.index')) }}">جميع المناطق</a><i class="fa fa-circle"></i>
        </li>
        <li><span>تعديل بيانات المنطقة</span></li>
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
                تعديل بيانات منطقة : <b style="color: red">{{ $province->name_ar }}</b>
              </span>
            </div>
          </div>
          <div class="portlet-body form">
            <form id="updateForm" method="post" action="{{url(route('provinces.update',$province->id))}}" class="form-horizontal form-row-seperated">
              
              {{ csrf_field() }}
              
              <input name="_method" type="hidden" value="PUT">
              
              <div class="form-body">
                
                <div class="form-group">
                  <label class="control-label col-md-3">
                    اسم المنطقة [ar]
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-9">
                    <input type="text" name="name_ar" value="{{ $province->name_ar }}" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">
                    اسم المنطقة [en]
                    <span class="required">*</span>
                  </label>
                  <div class="col-md-9">
                    <input type="text" name="name_en" value="{{ $province->name_en }}" class="form-control">
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
                        @if ($province->status == 1) checked="true" @endif>
                        <span></span>
                      </label>
                      <label class="mt-radio mt-radio-outline"> غير مفعل
                        <input type="radio" name="status" value="0"
                        @if ($province->status == 0) checked="true" @endif>
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
                    <select name="brand_id" id="single" class="form-control select2" >
                      <option></option>
                      @foreach ($governorates as $governorate)
                      <option value="{{$governorate->id}}"
                        @if ($governorate->id == $province->governorate_id)
                        selected
                        @endif>
                        {{ $governorate->name_ar }}
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
                    اضافة
                    </button>
                    <a href="{{url(route('provinces.index')) }}" class="btn btn-lg red">
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