@extends('admin._layouts.master')
@section('title','جميع طلبات المعاينة')
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
                    <a href="#">جميع طلبات المعاينة</a>
                </li>
            </ul>
        </div>
        
        <h1 class="page-title"></h1>

        <div class="row">
            <div class="profile-content">
                {{-- Content --}}
                <div class="portlet light">
                    <div class="portlet-body">
                        {{-- Filter DataTable --}}
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="15%"> بحث بتاريخ الانشاء </th>
                                    <th width="15%"> بحث بالحالة </th>
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
                                    <th>اسم العميل</th>
                                    <th>البريد</th>
                                    <th>رقم الهاتف</th>
                                    <th>تاريخ طلب المعاينة</th>
                                    <th>الحالة</th>
                                    <th>ملاحظات</th>
                                    <th>تاريخ الانشاء</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="row"></div>
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
            url:"{{ route('previews.dataTable') }}",
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
            { "data": "full_name" , "orderable": false},
            { "data": "email" , "orderable": false},
            { "data": "mobile" , "orderable": false},
            { "data": "time" ,"width": "140px"},
            { "data": "preview_status_id" },
            { "data": "note" },
            { "data": "created_at" },
            { "data": "options"  , "orderable": false ,"width": "10%"},
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