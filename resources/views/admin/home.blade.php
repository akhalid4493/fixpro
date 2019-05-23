@extends('admin._layouts.master')
@section('title','الصفحة الرئيسية')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('admin')) }}">الرئيسية</a>
                </li>
            </ul>
        </div>

        <h4> اهلا بك ، <b style="color:red">{{ Auth::user()->name }} </b></h4>

        <div class="row">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-green"></i>
                        <span class="caption-subject font-green bold uppercase">
                            البيانات
                        </span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="mt-element-card mt-element-overlay">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 blue">
                                    <div class="visual">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="{{$allUsers}}">0</span>
                                        </div>
                                        <div class="desc">الاعضاء</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 green">
                                    <div class="visual">
                                        <i class="fa fa-usd"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <small class="font-wihte-sharp">KWD</small>
                                            <span data-counter="counterup" data-value="{{Price($totalSubscriptions)}}">0.000</span>
                                        </div>
                                        <div class="desc"> الاشتراكات السنوية</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 red">
                                    <div class="visual">
                                        <i class="fa fa-usd"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <span data-counter="counterup" data-value="{{$donePreviews}}">0</span>
                                        </div>
                                        <div class="desc">طلبات المعاينة المكتملة</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <a class="dashboard-stat dashboard-stat-v2 yellow">
                                    <div class="visual">
                                        <i class="fa fa-usd"></i>
                                    </div>
                                    <div class="details">
                                        <div class="number">
                                            <small class="font-wihte-sharp">KWD</small>
                                            <span data-counter="counterup" data-value="{{Price($allProfit)}}">0.000</span>
                                        </div>
                                        <div class="desc">المبيعات بالدينار</div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class=" icon-layers font-green"></i>
                            <span class="caption-subject font-green bold uppercase">
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

                                    <div class="col-md-6">
                                        <b class="page-title">مبيعات الطلبات الشهرية</b>
                                        <canvas id="OrderProfit" width="540" height="270" ></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <b class="page-title">الطلبات</b>
                                        <canvas id="OrderStatus" width="540" height="270" ></canvas>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

{{-- JQUERY++ --}}
@section('scripts')

<script>
    // USERS COUNT BY DATE
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


<script>
    var ctx = document.getElementById("OrderProfit");
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
    var ctx = document.getElementById("OrderStatus").getContext('2d');
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
@stop
