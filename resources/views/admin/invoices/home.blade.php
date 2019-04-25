@extends('admin._layouts.master')
@section('title','جميع اشتراكات الاعضاء')
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
					<a href="#">عرض اشتراكات الاعضاء</a>
				</li>
			</ul>
		</div>
		
		<h1 class="page-title"></h1>
		
		<div class="row">
            <div class="profile-content">
                <div class="portlet light">
                    <div class="portlet-body">
						{{-- Filter DataTable --}}
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="15%"> بحث بتاريخ الفاتورة </th>
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
                                    <th>رقم الاشتراك</th>
                                    <th>قيمة الفاتورة</th>
                                    <th>تاريخ الفاتورة</th>
                                    <th>اسم المشترك</th>
                                    <th>خيارات</th>
                                </tr>
                            </thead>
                            <tfoot style="background: #36414f;color: white;">
                                <tr>
                                    <td style="border: none;"></td>
                                    <td style="border: none;"></td>
                                    <td style="border: none;">المجموع الكلي</td>
                                    <td style="border: none;"></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            @permission('delete_invoices')
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
                                    <button type="submit" id="deleteChecked" class="btn red btn-sm" onclick="deleteAllChecked('{{url(route('invoices.deletes')) }}')">
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
            url:"{{ route('invoices.dataTable') }}",
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
        'footerCallback': function ( row, data, start, end, display ) {

            var api = this.api();
            nb_cols = api.columns().nodes().length;
            var j = 3;

            while(j < nb_cols){

                var pageTotal = api.column( j, { page: 'current'} ).data().reduce( function (a, b) {
                    
                    return Number(a) + Number(b);
                    
                    },0 
                );

                $(api.column(j).footer()).html(pageTotal+' KWD');

                j++;
            } 
        },
        "order": [[ 1 , "desc" ]],
        "columns":[
            { "data": "listBox"   , "orderable": false  },
            { "data": "id"              },
            { "data": "subscription_id" },
            { "data": "price"           },
            { "data": "paid_at"    		},
            { "data": "user_name" , "orderable": false  },
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