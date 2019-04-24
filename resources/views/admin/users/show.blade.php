@extends('admin._layouts.master')
@section('title','بيانات العضو')
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
                    <span>بيانات العضو</span>
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
                                <div class="col-md-2">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="active">
                                            <a data-toggle="tab" href="#general">
                                                <i class="fa fa-cog"></i> بيانات العضو العامة
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#address">
                                                <i class="fa fa-picture-o"></i> العناوين
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#previews">
                                                <i class="fa fa-eye"></i> طلبات المعاينة
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#orders">
                                                <i class="fa fa-eye"></i> الطلبات
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-10 contentPrint">
                                <div class="tab-content">
                                    @include('admin.users.tabs.general')
                                    @include('admin.users.tabs.address')
                                    @include('admin.users.tabs.previews') 
                                    @include('admin.users.tabs.orders') 
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


@section('scripts')

@yield('addressDT')
@yield('PreviewDT')
@yield('OrderDT')
    
<script src="{{ url('admin/js/custom-datatable.js') }}"></script>
@stop