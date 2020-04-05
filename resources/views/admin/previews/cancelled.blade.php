@extends('admin._layouts.master')
@section('title','جميع طلبات المعاينة الملغية')
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
                    <a href="#">جميع طلبات المعاينة الملغية</a>
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
                                    <th width="15%"> بحث بالخدمة </th>
                                    <th width="15%"> بحث بالمنطقة </th>
                                    <th width="15%"> بحث بالمحافظة </th>
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
                                                <select name="service" class="form-control">
                                                    <option value="">اختر</option>
                                                    @foreach ($services as $service)
                                                      <option value="{{ $service->id }}">{{ $service->name_ar }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select name="province" class="form-control">
                                                    <option value="">اختر</option>
                                                    @foreach ($provinces as $province)
                                                      <option value="{{ $province->id }}">{{ $province->name_ar }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select name="governorate" class="form-control">
                                                    <option value="">اختر</option>
                                                    @foreach ($governorates as $governorate)
                                                      <option value="{{ $governorate->id }}">{{ $governorate->name_ar }}</option>
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
                                    <th>Seen</th>
                                    <th>اسم العميل</th>
                                    <th>حالة الاشتراك</th>
                                    <th>المنطقة</th>
                                    <th>تاريخ طلب المعاينة</th>
                                    <th>الخدمة المطلوبة</th>
                                    <th>الحالة</th>
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
            url:"{{ route('previews.dataTable','status_id=6') }}",
            type:"GET",
            data : {
                req : data,
            },
        },
        "stateSave": true,
        "processing":true,
        "serverSide":true,
        "pageLength": 25,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Arabic.json"
        },
        "order": [[ 1 , "desc" ]],
        "columns":[
            { "data": "listBox"   , "orderable": false  },
            { "data": "id"    },
            { "data": "seen"},
            { "data": "user_id"},
            { "data": "subscription"   , "orderable": false  },
            { "data": "address"   , "orderable": false  },
            { "data": "time" ,"width": "140px"},
            { "data": "details", "render": "[ , ].service.name_ar" ,"orderable": false},
            { "data": "preview_status_id" },
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
