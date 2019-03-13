@extends('admin._layouts.master')
@section('title','جميع المناطق')
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
					<a href="#">عرض المناطق</a>
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
							<span class="caption-subject bold uppercase"> جدول المناطق</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-toolbar">
							<div class="row">
								<div class="col-md-6">
									<div class="btn-group">
										<a href="{{ url(route('provinces.create')) }}" class="btn sbold green">
											<i class="fa fa-plus"></i> اضافة منطقة جديدة
										</a>
									</div>
								</div>
							</div>
						</div>
						<table class="table table-striped table-bordered table-hover" id="dataTable">
							<thead>
								<tr>
									<th>#</th>
									<th>العنوان بالعربي</th>
									<th>العنوان بالانجليزي</th>
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
		"ajax": "{{ route('provinces.dataTable') }}",
		"processing":true,
		"serverSide":true,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Arabic.json"
		},
		"order": [[ 0 , "desc" ]],
		"columns":[
		
		{ "data": "id"      },
		{ "data": "name_ar" },
		{ "data": "name_en" },
		{ "data": "status"  },
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


{{-- <script>
    var ctx = document.getElementById("myChart2").getContext('2d');
    var labels = {!! $categories !!};
    var count = {{ $itemsOfCategory }};
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'منتجات المناطق',
                data: count,
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
	            xAxes: [{
	                stacked: true
	            }],
	            yAxes: [{
	                stacked: true
	            }]
	        }
	    }
    });
</script>


<script>
    var ctx = document.getElementById("myChart3").getContext('2d');
    var labels = {!! $categories2 !!};
    var count = {{ $adsOfCategory }};
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'اعلانات المناطق',
                data: count,
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
        animation: {
            duration: 0, // general animation time
        },
        hover: {
            animationDuration: 0, // duration of animations when hovering an item
        },
        responsiveAnimationDuration: 0, // animation duration after a resize
    }
    });
</script> --}}

@endsection
