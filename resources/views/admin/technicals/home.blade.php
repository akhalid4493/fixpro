@extends('admin._layouts.master')
@section('title','جميع الموظفين')
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
                    <a href="#">جميع الموظفين</a>
                </li>
            </ul>
        </div>
        
        <h1 class="page-title"></h1>

        <div class="row">
            <div class="profile-content">
                {{-- Statistics --}}
                {{-- <div class="portlet light">
                    <div class="portlet-title tabbable-line">
                        <div class="caption caption-md">
                            <i class="icon-globe theme-font hide"></i>
                            <span class="caption-subject font-blue-madison bold uppercase">
                                احصائيات
                            </span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="mt-element-card mt-card-round mt-element-overlay">
                            <div class="row">
                                <div class="general-item-list">
                                    <div class="col-md-6">
                                        <b class="page-title">تاريخ اضافة الموظفين</b>
                                        <canvas id="myChart2" width="540" height="270" ></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <b class="page-title">حالة الموظفين</b>
                                        <canvas id="myChart" width="540" height="270" ></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- Content --}}
                <div class="portlet light">
                    <div class="portlet-body">
                        {{-- Filter DataTable --}}
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="15%"> بحث بتاريخ الانشاء </th>
                                    <th width="15%"> بحث بالحالة </th>
                                    <th width="15%"> بحث بالصلاحيات </th>
                                </tr>
                                <tr role="row" class="filter">
                                    <form id="formFilter">
                                        <td>
                                            <div id="reportrange" class="btn default">
                                                <i class="fa fa-calendar"></i> &nbsp;
                                                <span> </span>
                                                <b class="fa fa-angle-down"></b>
                                                <input type="hidden" name="from">
                                                <input type="hidden" name="to">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select name="active" class="form-control">
                                                    <option value="">اختر</option>
                                                    <option value="1">مفعل</option>
                                                    <option value="0">غير مفعل</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select name="roles" class="form-control">
                                                    <option value="">اختر</option>
                                                    <option value="normal">Normal Users</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role['id'] }}">
                                                            {{ $role['display_name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>

                                    </form>
                                    <td>
                                        <button class="btn btn-sm green btn-outline filter-submit margin-bottom" id="search"> 
                                            <i class="fa fa-search"></i>بحث
                                        </button>
                                        
                                        <button class="btn btn-sm red btn-outline filter-cancel">
                                            <i class="fa fa-times"></i>حذف
                                        </button>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        {{-- DataTable --}}
                        <table class="table table-striped table-bordered table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th width="2%" class="chkParent">
                                        <a href="#.">تحديد الكل</a>
                                    </th>
                                    <th width="2%">#</th>
                                    <th>الصورة الشخصية</th>
                                    <th>الاسم</th>
                                    <th>البريد</th>
                                    <th>رقم الهاتف</th>
                                    <th>الحالة</th>
                                    <th>الصلاحيات</th>
                                    <th>تاريخ الانشاء</th>
                                    <th>خيارات</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="row">
                            @permission('delete_technicals')
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select name="xx" class="form-control">
                                            <option value="delete">
                                                حذف المحدد
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" id="deleteChecked" class="btn red btn-sm" onclick="deleteAllChecked('{{ url(route('technicals.deletes')) }}')">
                                    تطبيق
                                    </button>
                                </div>
                            @endpermission
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@stop

@section('scripts')
<script> 
 function tableGenerate(data='') {

    var dataTable =
    $('#dataTable').DataTable({
        "ajax" : {
            url:"{{ route('technicals.dataTable') }}",
            type:"GET",
            data : { 
                req : data, 
            },
        },
        "processing":true,
        "serverSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Arabic.json"
        },
        "order": [[ 1 , "desc" ]],
        "columns":[
            { "data": "listBox"   , "orderable": false  },
            { "data": "id"    },
            { "data": "image" , "orderable": false , "width": "1%" ,
              "render": 
              function(data, type, row){ 
                return '<img src="'+data+'" width="50px"/>'
              },
            },
            { "data": "name" },
            { "data": "email"    },
            { "data": "mobile"    },
            { "data": "active"    },
            { "data": "roles", "render": "[ , ].display_name" ,"orderable": false ,"width": "5%"},
            { "data": "created_at" },
            { "data": "options"   , "orderable": false  },
        ],
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50 , 100 , 500 , -1 ],
            [ '10 rows', '25 rows', '50 rows', '100 rows' , '500 rows' ,'Show all' ]
        ],
        buttons: [
        'pageLength',
        'colvis',{
                extend: 'csv',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
            extend: 'print',
            exportOptions: {
                stripHtml: true,
                columns: ':visible'
                }
            },
        ]
    });
}
</script>

<script src="{{ url('admin/js/custom-datatable.js') }}"></script>

@stop