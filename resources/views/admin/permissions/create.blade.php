@extends('admin._layouts.master')
@section('title','اضافة مجموعة الصلاحيات')
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
                    <a href="{{ url(route('permissions.index')) }}">جميع الصلاحيات</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">اضافة مجموعة الصلاحيات</a>
                </li>
            </ul>
        </div>
        <h1 class="page-title"></h1>
        
        <div class="row">
            <div class="profile-content">
                <div class="portlet light ">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe theme-font hide"></i>
                            <span class="caption-subject font-blue-madison bold uppercase">
                                اضافة صلاحيات جديدة
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="form" action="{{url(route('permissions.store'))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated"
                            method="POST">
                            @csrf
                            <div class="portlet">
                                <div class="portlet-body">
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
                                                        عنوان المقال
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="name" placeholder="الصلاحية" class="form-control">
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
                                                        <a href="{{url(route('permissions.index')) }}" class="btn btn-lg red">
                                                            الخلف
                                                        </a>
                                                    </div>
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