@extends('admin._layouts.master')
@section('title','تعديل مجموعة الصلاحيات - '. $role['display_name'])
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
                    <a href="{{ url(route('roles.index')) }}">جميع الصلاحيات</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">تعديل مجموعة الصلاحيات</a>
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
                                تعديل صلاحيات : <b>{{ $role['display_name'] }}</b>
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="updateForm" action="{{url(route('roles.update',$role->id))}}" enctype="multipart/form-data" class="form-horizontal form-row-seperated"
                            method="POST">
                            
                            <input name="_method" type="hidden" value="PUT">
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
                                                        اسم المجموعة
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9">
                                                        <input type="text" name="name" placeholder="الصلاحية : Data Entry" class="form-control" value="{{ $role['display_name'] }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-2">
                                                        الوصف
                                                    </label>
                                                    <div class="col-md-9">
                                                        <textarea name="description" class="form-control" cols="30" rows="10">{!! $role['description'] !!}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-2">
                                                        تحديد الصلاحيات
                                                        <span class="required">*</span>
                                                    </label>
                                                    <div class="col-md-9">
                                                        <div class="mt-checkbox-list">
                                                            <ul>
                                                                @foreach ($perms->groupBy('display_name') as $key => $perm)
                                                                <li style="list-style-type:none">
                                                                    <label class="mt-checkbox">
                                                                        <input type="checkbox" class="permission-group">
                                                                        <strong>{{title_case(str_replace('_',' ', $key))}}</strong>
                                                                        <span></span>
                                                                    </label>
                                                                    <ul style="list-style-type:none">
                                                                        @foreach($perm as $permission)
                                                                        <li style="list-style-type:none">
                                                                            <label class="mt-checkbox">
                                                                                <input class="child" type="checkbox" name="permission[]" value="{{$permission->id}}" {{in_array($permission->id,$role_perms)?"checked":""}}>
                                                                                {{title_case(str_replace('_', ' ', $permission->name))}}
                                                                                <span></span>
                                                                            </label>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
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
                                                        تعديل
                                                        </button>
                                                        <a href="{{url(route('roles.index')) }}" class="btn btn-lg red">
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
@section('scripts')
<script>
$(document).ready(
function(){
$(".permission-group").click(function () {
$(this).parents('li').find('.child').prop('checked', this.checked);
});
}
);
</script>
@stop