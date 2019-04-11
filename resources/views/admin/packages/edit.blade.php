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
        <div class="portlet light">
          
          <div class="portlet-title tabbable-line">
            <div class="caption caption-md">
              <i class="icon-globe theme-font hide"></i>
              <span class="caption-subject font-blue-madison bold uppercase">
                تعديل بيانات الباقة : <b style="color:red">{{ $package->name_ar }}</b>
              </span>
            </div>
          </div>
          
          <div class="portlet-body form">
            <form id="updateForm" method="POST" action="{{url(route('packages.update',$package->id))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated">
              
              @csrf
              <input name="_method" type="hidden" value="PUT">
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
                          عنوان الباقة [ar]
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                          <input type="text" name="name_ar" placeholder="باقة ذهبية" class="form-control" value="{{ $package->name_ar }}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">
                          عنوان الباقة [en]
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                          <input type="text" name="name_en" placeholder="Gold Package" class="form-control" value="{{ $package->name_en }}">
                        </div>
                      </div>
                      {{-- <div class="form-group">
                        <label class="control-label col-md-3">
                          سعر الباقة
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                          <input type="text" name="price" placeholder="باقة ذهبية" class="form-control" value="{{ $package->price }}">
                        </div>
                      </div> --}}
                      {{-- <div class="form-group">
                        <label class="control-label col-md-3">
                          عدد شهور اشتراك الباقة
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                          <input type="text" name="months" placeholder="Gold Package" class="form-control" value="{{ $package->months }}">
                        </div>
                      </div> --}}
                      <div class="form-group">
                        <label class="control-label col-md-3">
                          وصف الباقة [ar]
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                          <textarea name="description_ar" class="form-control ckeditor" cols="30" rows="10">{!! $package->description_ar !!}</textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">
                          وصف الباقة [en]
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                          <textarea name="description_en" class="form-control ckeditor" cols="30" rows="10">{!! $package->description_en !!}</textarea>
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
                              <input type="radio" name="status" value="1"
                              @if ($package['status'] == 1)
                              checked=""
                              @endif>
                              <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                              غير مفعل
                              <input type="radio" name="status" value="0"
                              @if ($package['status'] == 0)
                              checked=""
                              @endif>
                              <span></span>
                            </label>
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
                        تعديل
                        </button>
                        <a href="{{url(route('packages.index')) }}" class="btn btn-lg red">
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