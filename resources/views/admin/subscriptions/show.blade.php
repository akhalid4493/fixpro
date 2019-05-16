@extends('admin._layouts.master')
@section('title','بيانات الاشتراك')
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
                    <a href="{{ url(route('subscriptions.index')) }}">جميع الاشتراكات</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>بيانات الاشتراك</span>
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
                                            <a data-toggle="tab" href="#subscription">
                                                <i class="fa fa-cog"></i> بيانات اشتراك العضو
                                            </a>
                                            <span class="after"></span>
                                        </li>
                                        @foreach ($subscription->monthlyBilling as $key => $billing)
                                            <li>
                                                <a data-toggle="tab" href="#invoices{{$billing['id']}}">
                                                    <i class="fa fa-cog"></i> الفاتورة #{{ ++$key }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9 contentPrint">
                                <div class="tab-content">
                                    @include('admin.subscriptions.pdf.subscriptions')
                                    @include('admin.subscriptions.pdf.invoices')
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