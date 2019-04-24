@extends('admin._layouts.master')
@section('title','جميع الاعضاء')
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
                    <a href="#">جميع الاعضاء</a>
                </li>
            </ul>
        </div>
        
        <h1 class="page-title"></h1>

        <div class="row">
            <div class="profile-content">
                {{-- Statistics --}}
                <div class="portlet light">
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
                                        <b class="page-title">تاريخ اضافة الاعضاء</b>
                                        <canvas id="myChart2" width="540" height="270" ></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <b class="page-title">حالة الاعضاء</b>
                                        <canvas id="myChart" width="540" height="270" ></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Content --}}
                <div class="portlet light">
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="{{url(route('users.create'))}}" class="btn sbold green">
                                            <i class="fa fa-plus"></i> اضافة
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Filter DataTable --}}
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="15%"> بحث بتاريخ الانشاء </th>
                                    <th width="15%"> بحث بالحالة </th>
                                    <th width="15%"> بحث حالة الاشتراك </th>
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
                                                <select name="subscription" class="form-control">
                                                    <option value="">اختر</option>
                                                    <option value="1">مشترك</option>
                                                    <option value="0">غير مشترك</option>
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
                                    <th>الاشتراك</th>
                                    <th>رقم الهاتف</th>
                                    <th>الحالة</th>
                                    <th>الصلاحيات</th>
                                    <th>تاريخ الانشاء</th>
                                    <th>خيارات</th>
                                </tr>
                            </thead>
                        </table>
                        <div class="row">
                            @permission('delete_users')
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
                                    <button type="submit" id="deleteChecked" class="btn red btn-sm" onclick="deleteAllChecked('{{ url(route('users.deletes')) }}')">
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
            url:"{{ route('users.dataTable') }}",
            type:"GET",
            data : { 
                req : data, 
            },
        },
        "processing":true,
        "serverSide":true,
        "scrollX":true,
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
            { "data": "subscription"    , "orderable": false },
            { "data": "mobile"    },
            { "data": "active"    },
            { "data": "roles", "render": "[ , ].display_name" ,"orderable": false},
            { "data": "created_at" },
            { "data": "options"   , "orderable": false },
        ],
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50 , 100 , 500],
            [ '10 rows', '25 rows', '50 rows', '100 rows' , '500 rows']
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

    var ctx = document.getElementById("myChart2").getContext('2d');
    var labels = {!! $userStDate['userDate'] !!};
    var countDate = {{ $userStDate['countDate'] }};
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'تاريخ اضافة الاعضاء',
                data: countDate,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54 , 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75 , 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54 , 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75 , 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });

    // COUNTRIES USERS
    var ctx = document.getElementById("myChart").getContext('2d');
    var countires  = {!! $userStActive['usersType'] !!};
    var usersCount = {{ $userStActive['usersCount'] }};
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: countires,
          datasets: [{
          backgroundColor: [
            "#e74c3c",
            "#34495e"
          ],
          data: usersCount
        }]
      }
    });
</script>

<script src="{{ url('admin/js/custom-datatable.js') }}"></script>

@stop