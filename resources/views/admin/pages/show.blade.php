@extends('admin._layouts.master')
@section('title','الملف الشخصي للمدير')
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
                    <a href="{{ url(route('admins.index')) }}">جميع المديرين</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>مدير</span>
                </li>
            </ul>
        </div>
        <h1 class="page-title"></h1>
        
        <div class="row">
            <div class="col-md-12">
                <div class="profile-content">
                    <div class="row">
                        
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span class="caption-subject font-blue-madison bold uppercase">
                                        الملف الشخصي للمدير :
                                        <p><b>{{$admin->full_name}}</b></p>
                                    </span>
                                </div>
                                
                                <div class="portlet-body">
                                    <div class="profile">
                                        <div class="tabbable-line tabbable-full-width">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_1_1">
                                                    <div class="row">
                                                        <div class="col-md-8 col-md-offset-4">
                                                            <ul class="list-unstyled profile-nav">
                                                                <li>
                                                                    <img src="{{ url('uploads/'.$admin->gender.'.png') }}" class="img-responsive pic-bordered" alt=""  style="max-width: 33%;" />
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-8 col-md-offset-4">
                                                            <div class="row">
                                                                <div class="col-md-8 profile-info">
                                                                    <h1 class="font-green sbold uppercase">{{$admin->full_name}}</h1>
                                                                    <p>
                                                                        <a href="javascript:;"> <b>تاريخ الانشاء</b> :
                                                                            {!!transDate(date("d M-Y", strtotime($admin->created_at)))
                                                                            !!}
                                                                        </a>
                                                                    </p>
                                                                    <ul class="list-inline">
                                                                        
                                                                        <li>
                                                                            <i class="fa fa-transgender"></i>
                                                                            {{$admin->gender}}
                                                                        </li>
                                                                        
                                                                    </ul>
                                                                    <ul class="list-inline">
                                                                        <li>
                                                                            <i class="fa fa-envelope"></i>
                                                                            {{$admin->email}}
                                                                        </li>
                                                                        <li>
                                                                            <i class="fa fa-mobile"></i>
                                                                            {{$admin->mobile}}
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <a href="{{url(route('admins.index')) }}" class="btn red">
                                                                    الرجوع للخلف
                                                                </a>
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
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
@stop