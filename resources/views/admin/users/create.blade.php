@extends('admin._layouts.master')
@section('title','اضافة عضو')
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
                    <a href="#">اضافة عضو</a>
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
                                اضافة عضو جديد
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="form" action="{{url(route('users.store'))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated" method="POST">
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
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_general">
                                            <div class="form-group">
                                                <label class="control-label col-md-2">
                                                    اسم العضو
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="text" name="name" placeholder="Amr Khaled" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">
                                                    البريد الالكتروني
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="email" name="email" placeholder="email@exmaple.com" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">
                                                    رقم الهاتف
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="mobile" name="mobile" placeholder="55050505" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">
                                                    كلمة المرور
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="col-md-9">
                                                    <input type="password" name="password" class="form-control" placeholder="كتابة كلمة المرور : [A-Z & 0-9]">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-2">
                                                    تآكيد كلمة المرور
                                                    <span class="required">*</span>
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
                                                            <input type="radio" name="active" value="1">
                                                            <span></span>
                                                        </label>
                                                        <label class="mt-radio mt-radio-outline">
                                                            غير مفعل
                                                            <input type="radio" name="active" value="0">
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
                                                            <input type="checkbox" name="roles[]" value="{{$role->id}}">
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
