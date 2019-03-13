@extends('admin._layouts.master')
@section('title','جميع الخدمات')
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
					<a href="#">عرض الخدمات</a>
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
							<span class="caption-subject bold uppercase"> جدول الخدمات</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6">
									<div class="btn-group">
										<a href="{{ url(route('services.create')) }}" class="btn sbold green">
											<i class="fa fa-plus"></i> اضافة خدمة جديدة
										</a>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="dataTable">
							<thead>
								<tr>
									<th>#</th>
									<th>الصورة</th>
									<th>العنوان بالعربي</th>
									<th>الحالة</th>
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

@stop

{{-- JQUERY+ --}}
@section('scripts')
<script>
	var dataTable =
	$('#dataTable').DataTable({
		"ajax": "{{ route('services.dataTable') }}",
		"processing":true,
		"serverSide":true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Arabic.json"
		},
		"order": [[ 0 , "desc" ]],
		"columns":[
		
		{ "data": "id"    },
		{ "data": "image" , "orderable": false , "width": "10%" ,
       	  "render": 
       	  function(data, type, row){ 
			return '<img src="'+data+'" width="50px"/>'
       	  },
    	},
		{ "data": "name_ar" },
		{ "data": "status" },
		{ "data": "created_at" },
		{ "data": "options"  , "orderable": false ,"width": "25%"},
		],
		dom: 'Bfrtip',
		lengthMenu: [
			[ 10, 25, 50 , 100 , 500 , -1 ],
			[ '10 rows', '25 rows', '50 rows', '100 rows' , '500 rows' ,'Show all' ]
		],
		buttons: [
		'pageLength',
		'colvis',
			{
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
</script>
@endsection
