@extends('admin._layouts.master')
@section('title','تعديل بيانات القسم')
@section('content')
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li>
          <a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
        </li>
        <li>
          <a href="{{ url(route('categories.index')) }}">جميع الاقسام</a><i class="fa fa-circle"></i>
        </li>
        <li><span>تعديل بيانات القسم</span></li>
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
                      تعديل بيانات قسم : <b style="color: red">{{ $category->name_ar }}</b>
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
                <div class="portlet-body">
                  <form id="updateForm" method="post" action="{{url(route('categories.update',$category->id))}}"
                    enctype="multipart/form-data">
                    
                    <input name="_method" type="hidden" value="PUT">
                    
                    {{ csrf_field() }}
                    <div class="tab-content">
                      
                      <div class="tab-pane active" id="tab_1_1">
                        <div class="form-group">
                          <label class="control-label">
                            عنوان القسم بالاعربي
                            <span class="required">*</span>
                          </label>
                          <input type="text" name="name_ar" placeholder="مثال : الشروط و الاحكام" class="form-control" value="{{ $category->name_ar }}">
                        </div>
                        <div class="form-group">
                          <label class="control-label">
                            عنوان القسم بالانجليزي
                            <span class="required">*</span>
                          </label>
                          <input type="text" name="name_en" placeholder="مثال : الشروط و الاحكام" class="form-control" value="{{ $category->name_en }}">
                        </div>
                        <div class="form-group form-md-radios">
                          <label>مستوى القسم</label>
                          <div class="md-radio-list">
                            <div class="md-radio">
                              <input type="radio" id="radio0" name="category_id" class="md-radiobtn" value=""@if ($category->category_id == null)
                              checked
                              @endif>
                              <label for="radio0">
                                <span class="inc"></span>
                                <span class="check"></span>
                                <span class="box"></span> مستوى رئيسي
                              </label>
                            </div>
                            @if (count($categories) > 0)
                            <label style="font-size: 14px;color: #888;opacity: 1;">
                              قسم فرعي من :
                            </label>
                            <div class="form-group">
                              <select name="country" id="single" class="form-control select2" >
                                <option></option>
                                @foreach ($categories as $cat)
                                <option value="{{$cat->id}}"
                                  @if ($cat->id == $category->category_id)
                                  selected
                                  @endif>
                                  {{transText($cat,'name')}}
                                </option>
                                @endforeach
                              </select>
                            </div>
                            @endif
                          </div>
                        </div>
                        <div class="form-group">
                          <label>
                            تغير الصورة
                          </label>
                          <input class="form-control" type="file" name="image">
                        </div>
                        <hr>
                        <div class="form-group">
                          <img src="{{ url($category->image) }}" class="img-thumbnail" style="width:15%">
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
                        تعديل
                        </button>
                        <a href="{{url(route('categories.index')) }}" class="btn-lg btn red">
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