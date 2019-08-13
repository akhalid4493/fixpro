@extends('admin._layouts.master')
@section('title','طلب الخدمة')
@section('content')
<style type="text/css" media="print">
@page {
    size  : auto;
    margin: 0;
}

@media print {
    a[href]:after {
        content: none !important;
    }
    .contentPrint{
        width: 100%;
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
        <h1 class="page-title"></h1>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="no-print">
                                <div class="col-md-3">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="active">
                                            <a data-toggle="tab" href="#preview">
                                                <i class="fa fa-cog"></i> فاتورة طلب المعاينة
                                            </a>
                                            <span class="after">
                                            </span>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#gallery">
                                                <i class="fa fa-picture-o"></i> الصور المرفقة
                                            </a>
                                        </li>

                                        <li>
                                            <a data-toggle="tab" href="#tech_gallery">
                                                <i class="fa fa-picture-o"></i> الصور المرفقة من الفني
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#technical">
                                                <i class="fa fa-eye"></i> تعديل و اسناد للفنين
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9 contentPrint">
                                <div class="tab-content">
                                    @include('admin.previews.tabs.preview')
                                    @include('admin.previews.tabs.gallery')
                                    @include('admin.previews.tabs.tech_gallery')
                                    @include('admin.previews.tabs.technical')
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
