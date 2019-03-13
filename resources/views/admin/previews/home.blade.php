@extends('admin._layouts.master')
@section('title','جميع المعاينات')
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
					<a href="#">عرض المعاينات</a>
				</li>
			</ul>
		</div>
		
		<h1 class="page-title"></h1>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue-hoki">
					<div class="portlet-title">
						<div class="caption font-light">
							<i class="icon-settings font-light"></i>
							<span class="caption-subject bold uppercase"> جدول المعاينات</span>
						</div>
					</div>
					{{-- DataTable --}}
						<div class="portlet-body">
							<div class="table-container">
								<table class="table table-striped table-bordered table-hover" id="dataTable">
									<thead>
										<tr>
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
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop

{{-- JQUERY+ --}}
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
        "order": [[ 0 , "desc" ]],
        "columns":[
			{ "data": "id"    },
			{ "data": "full_name" },
			{ "data": "email" },
			{ "data": "mobile" },
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

@endsection
