@extends('admin._layouts.master')
@section('title','معرض الصور')
@section('content')
@include('admin.media.addImages.addModal')

<div class="page-content-wrapper">
	<div class="page-content">

		<div class="page-bar">
			<ul class="page-breadcrumb">
				<li><a href="{{ url(route('admin')) }}">الرئيسية</a><i class="fa fa-circle"></i></li>
				<li><span>معرض الصور</span></li>
			</ul>
		</div>
		
		<h1 class="page-title"></h1>

		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">

					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-settings font-dark"></i>
							<span class="caption-subject bold uppercase"> 
								جدول معرض الصور 
							</span>
						</div>
					</div>

					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6">
									<div class="btn-group">
										<button type="button" class="btn sbold green" data-toggle="modal" data-target="#myModal">
										<i class="fa fa-plus"></i> اضافة صور جديدة 
										</button>
									</div>
								</div>
							</div>
						</div>

						<table class="table table-striped table-bordered table-hover" id="dataTable">
							<thead>
								<tr>
									<th>#</th>
									<th>الصورة</th>
									<th>الرابط</th>
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

@section('scripts')

<script>
    var dataTable =
    $('#dataTable').DataTable({
        "ajax": "{{ route('media.dataTable') }}",
		"processing":true,
		"serverSide":true,
		"stateSave":true,
		"language": {
		       	"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Arabic.json"
         },
		"columns":[
		
		{ "data": "id"},
        { "data": "image" , "orderable": false ,
       	  "render": function(data, type, row) { return '<img src="'+data+'" width="200px"/>' },
    	},
		{ "data": "image"},
        { "data": "options"  , "orderable": false ,"width": "20%"},

		]
	});

</script>

@endsection