@extends('admin._layouts.master')
@section('title','طلب الخدمة')
@section('content')
<style type="text/css" media="print">
@page {
size  : auto;/* auto is the initial value */
margin: 0;   /* this affects the margin in the printer settings */
}
@media print {
a[href]:after {
content: none !important;
}
.no-print, .no-print *{
display: none !important;
}
}
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('admin')) }}">الرئيسية</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('previews.index')) }}">جميع طلبات الخدمات</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>تفاصيل الطلب</span>
                </li>
            </ul>
        </div>
        
        <div class="row">
            <div class="profile-content">
                <div class="portlet light">
                    <div class="portlet-body">
                        <div class="portlet">
                            <div class="portlet-body">
                                <div class="tabbable-bordered">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#preview" data-toggle="tab">
                                                الطلب
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#gallery" data-toggle="tab">
                                                الصور المرفقة
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#edit" data-toggle="tab">
                                                تعديل و اسناد
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        @include('admin.previews.tabs.preview')
                                        @include('admin.previews.tabs.gallery')
                                        @include('admin.previews.tabs.edit')
                                    </div>
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