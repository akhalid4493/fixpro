@extends('admin._layouts.master')
@section('title','الفاتورة')
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
                    <a href="{{ url(route('orders.index')) }}">جميع الطلبات</a>
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
                        <div class="tabbable-bordered">
                            <div class="no-print">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#order" data-toggle="tab">
                                            الطلب
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#preview" data-toggle="tab">
                                            بيانات طلب المعاينة
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#edit" data-toggle="tab">
                                            تعديل الطلب
                                        </a>
                                    </li>
                                </ul>
                            </div>
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
@stop