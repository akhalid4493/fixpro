@extends('admin._layouts.master')
@section('title','تعديل بيانات قيمة التركيب')
@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="{{ url(route('installations.index')) }}">جميع قيمة التركيب</a>
          <i class="fa fa-circle"></i>
        </li>
        <li><span>تعديل بيانات قيمة التركيب</span></li>
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
                تعديل بيانات قيمة التركيب : <b style="color:red">{{ $installation->name_ar }}</b>
                  </span>
              </div>
          </div>
          <div class="portlet-body form">
            <form id="updateForm" method="POST" action="{{url(route('installations.update',$installation->id))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated">
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
                    <input name="type" type="hidden" value="{{ $installation->type }}">
                      <div class="form-group">
                        <label class="control-label col-md-3">
                          عنوان قيمة التركيب ar
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                          <input type="text" name="name_ar" placeholder="كرسي" class="form-control" value="{{ $installation->name_ar }}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">
                          عنوان قيمة التركيب en
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                          <input type="text" name="name_en" placeholder="Chair" class="form-control" value="{{ $installation->name_en }}">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">
                          سعر قيمة التركيب
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                          <input type="text" name="price" placeholder="25.000" class="form-control" value="{{ number_format($installation->price,3)}}">
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
                              @if ($installation['status'] == 1)
                              checked=""
                              @endif>
                              <span></span>
                            </label>
                            <label class="mt-radio mt-radio-outline">
                              غير مفعل
                              <input type="radio" name="status" value="0"
                              @if ($installation['status'] == 0)
                              checked=""
                              @endif>
                              <span></span>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-body">
                        <div class="form-group">
                          <label class="control-label col-md-3">
                            الصورة
                          </label>
                          <div class="col-md-9">
                            <input class="form-control" type="file" name="image">
                            <div class="form-group">
                              <img src="{{url($installation->image)}}" class="img-thumbnail" style="width:15%">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- SEO CONTENT --}}
                  <div class="tab-pane" id="seo">
                    <div class="form-body">
                      <div class="form-group">
                        <label class="control-label col-md-3">
                          Meta Keywords
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                          <input type="text" name="seo_keywords_ar" placeholder="دكتور سالمين ، دكتور،سالمين" class="form-control" value="{{$installation->seo_keywords_ar}}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">
                          Meta Description
                          <span class="required">*</span>
                        </label>
                        <div class="col-md-9">
                          <textarea type="text" name="seo_description_ar" rows="10" cols="10" class="form-control">{!!$installation->seo_description_ar!!}</textarea>
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
                        <a href="{{url(route('installations.index')) }}" class="btn btn-lg red">
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