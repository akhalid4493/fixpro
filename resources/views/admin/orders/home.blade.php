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

		@permission('statistics')

		<div class="row">
			<div class="profile-content">
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
										<b class="page-title">مبيعات الطلبات الشهرية</b>
										<canvas id="myChart" width="540" height="270"></canvas>
									</div>
									<div class="col-md-6">
										<b class="page-title">الطلبات</b>
										<canvas id="myChart2" width="540" height="270"></canvas>
									</div>
									<div class="col-md-6">
										<b class="page-title">ربح الطلبات</b>
										<canvas id="myChart3" width="540" height="270"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endpermission

		<div class="row">
			<div class="profile-content">
				<div class="portlet light">
					<div class="portlet-body">
						{{-- Filter DataTable --}}
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr role="row" class="heading">
									<th width="15%"> بحث بتاريخ الانشاء </th>
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
									<th>اسم العميل</th>
									<th>البريد</th>
									<th>رقم الهاتف</th>
									<th>المجموع الكلي</th>
									<th>المجموع الكلي للربح</th>
									<th>طريقة الدفع</th>
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

{{-- JQUERY+ --}}
@section('scripts')
<script>
	function tableGenerate(data = '') {
		var dataTable =
			$('#dataTable').DataTable({
				"ajax": {
					url: "{{ route('orders.dataTable') }}",
					type: "GET",
					data: {
						req: data,
					},
				},
				"processing": true,
				"serverSide": true,
				"language": {
					"url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Arabic.json"
				},
				"order": [
					[1, "desc"]
				],
				"columns": [{
						"data": "listBox",
						"orderable": false
					},
					{
						"data": "id"
					},
					{
						"data": "full_name",
						"orderable": false
					},
					{
						"data": "email",
						"orderable": false
					},
					{
						"data": "mobile",
						"orderable": false
					},
					{
						"data": "total"
					},
					{
						"data": "total_profit"
					},
					{
						"data": "method"
					},
					{
						"data": "order_status_id"
					},
					{
						"data": "created_at"
					},
					{
						"data": "options",
						"orderable": false,
						"width": "10%"
					},
				],
				dom: 'Bfrtip',
				lengthMenu: [
					[10, 25, 50, 100, 500, -1],
					['10 rows', '25 rows', '50 rows', '100 rows', '500 rows', 'Show all']
				],
				buttons: [
					'pageLength',
					'colvis', {
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

<script>
	var ctx = document.getElementById("myChart");
	var labels = {!!$orderChart['profit_dates'] !!};
	var count = {{$orderChart['profits']}};
	var data = {
		labels: labels,
		datasets: [{
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
		}]
	};
	var myLineChart = new Chart(ctx, {
		type: 'line',
		label: labels,
		data: data,
		options: {
			animation: {
				animateScale: true
			}
		}
	});
</script>

<script>
	var ctx = document.getElementById("myChart3");
	var labels = {!!$order_profit['profit_dates'] !!};
	var count = {{$order_profit['profits']}};
	var data = {
		labels: labels,
		datasets: [{
			label: "مبيعات صافي الربح",
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
		}]
	};
	var myLineChart = new Chart(ctx, {
		type: 'line',
		label: labels,
		data: data,
		options: {
			animation: {
				animateScale: true
			}
		}
	});
</script>

<script>
	var ctx = document.getElementById("myChart2").getContext('2d');
	var orders = {!!$orderStatus['ordersType'] !!};
	var ordersCount = {{$orderStatus['ordersCount']}};
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

<script src="{{ url('admin/js/custom-datatable.js') }}"></script>

@endsection
