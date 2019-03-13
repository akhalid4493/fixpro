@extends('admin._layouts.master')
@section('title','جميع الطلبات')
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
					<a href="#">عرض الطلبات</a>
				</li>
			</ul>
		</div>
		
		<h1 class="page-title"></h1>
		
		
		<div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">احصائيات</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="mt-element-card mt-card-round mt-element-overlay">
                            <div class="row">
                                <div class="general-item-list">
                                    <div class="col-md-6">
                                        <b class="page-title">مبيعات الطلبات الشهرية</b>
                                        <canvas id="myChart" width="540" height="270" ></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <b class="page-title">الطلبات</b>
                                        <canvas id="myChart2" width="540" height="270" ></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
       

		<div class="row">
			<div class="col-md-12">
				<div class="portlet box blue-hoki">
					<div class="portlet-title">
						<div class="caption font-light">
							<i class="icon-settings font-light"></i>
							<span class="caption-subject bold uppercase"> جدول الطلبات</span>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover" id="dataTable">
							<thead>
								<tr>
									<th>#</th>
									<th>اسم العميل</th>
									<th>البريد</th>
									<th>رقم الهاتف</th>
									<th>المجموع الكلي</th>
									<th>طريقة الدفع</th>
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
		"ajax": "{{ route('orders.dataTable') }}",
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
		{ "data": "total" },
		{ "data": "method" },
		{ "data": "order_status_id" },
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


<script>
	var ctx = document.getElementById("myChart");
    var labels = {!! $orderChart['profit_dates'] !!};
    var count  = {{ $orderChart['profits'] }};
    var data   = {
        labels: labels,
        datasets: [
            {
                label: "ارباح الطلبات الشهرية",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "#36A2EB",
                borderColor: "#36A2EB",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "#36A2EB",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "#36A2EB",
                pointHoverBorderColor: "#FFCE56",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: count,
                spanGaps: false,
            } 
        ]
    };
    var myLineChart = new Chart(ctx, {
        type: 'line',
        label:labels,
        data: data,
        options: {
            animation:{
                animateScale:true
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById("myChart2").getContext('2d');
    var orders  = {!! $orderStatus['ordersType'] !!};
    var ordersCount = {{ $orderStatus['ordersCount'] }};
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: orders,
          datasets: [{
          backgroundColor: [
            "#2ea0ee",
            "#34495e",
            "#f2c500",
            "#2ac6d4",
            "#e74c3c",
          ],
          data: ordersCount
        }]
      }
    });
</script>

@endsection
