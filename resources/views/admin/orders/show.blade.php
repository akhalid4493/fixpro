@extends('admin._layouts.master')
@section('title','الفاتورة')
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
                    <a href="{{ url(route('orders.index')) }}">جميع الفواتير</a>
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
                                            <a data-toggle="tab" href="#order">
                                                <i class="fa fa-cog"></i> فاتورة الطلب
                                            </a>
                                            <span class="after"></span>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#preview">
                                                <i class="fa fa-cog"></i> طلب المعاينة
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#edit">
                                                <i class="fa fa-eye"></i> تعديل حالة الفاتورة
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9 contentPrint">
                                <div class="tab-content">
                                    @include('admin.orders.tabs.order')
                                    @include('admin.orders.tabs.preview')
                                    @include('admin.orders.tabs.edit')
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
