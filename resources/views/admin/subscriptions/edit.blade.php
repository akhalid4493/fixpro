@extends('admin._layouts.master')
@section('title','تعديل بيانات الاشتراك')
@section('content')
@include('admin.subscriptions.parts.invoices')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('subscriptions.index')) }}">جميع الباقات</a><i class="fa fa-circle"></i>
                </li>
                <li><span>تعديل بيانات الاشتراك</span></li>
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
                                تعديل بيانات الاشتراك
                            </span>
                        </div>
                    </div>
                    
                    <div class="portlet-body form">
                        <form id="updateForm" method="POST" action="{{url(route('subscriptions.update',$subscription->id))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated">
                            
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            <div class="tabbable-bordered">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#general" data-toggle="tab"> بيانات عامة </a>
                                    </li>
                                    <li>
                                        <a href="#invoices" data-toggle="tab"> الدفعات والفواتير </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    
                                    {{-- GENERAL CONTENT --}}
                                    @include('admin.subscriptions.tabs.subscription')

                                    @include('admin.subscriptions.tabs.invoices')

                                    <div class="form-actions">
                                        <div id="result" style="display: none"></div>
                                        
                                        <div class="progress-info" style="display: none">
                                            <div class="progress">
                                                <span class="progress-bar progress-bar-warning"></span>
                                            </div>
                                            <div class="status" id="progress-status"></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" id="submit" class="btn btn-lg blue">
                                            تعديل
                                            </button>
                                            <a href="{{url(route('subscriptions.index')) }}" class="btn btn-lg red">
                                                الخلف
                                            </a>
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