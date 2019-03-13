@extends('admin._layouts.master')
@section('title','الفاتورة')
@section('content')
<style type="text/css" media="print">
@page {
size  : auto;/* auto is the initial value */
margin: 0;   /* this affects the margin in the printer settings */
}
@media print {
a[href]:after {
content: none !important;
}
.no-print, .no-print *{
display: none !important;
}
}
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('admin')) }}">الرئيسية</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('orders.index')) }}">جميع الطلبات</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>تفاصيل الطلب</span>
                </li>
            </ul>
        </div>
        
        <div class="invoice-content-2 bordered">
            
            <div class="row invoice-head">
                <div class="col-md-7 col-xs-6">
                    <div class="invoice-logo" style="text-align: right;">
                        <h3 class="blod uppercase">{{ settings('site_name_en') }}</h3>
                    </div>
                </div>
                <div class="col-md-5 col-xs-6">
                    <div class="company-address">
                        <h3 class="bold uppercase">#{{ $order['id'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="row invoice-cust-add">
                <div class="col-xs-3">
                    <h2 class="invoice-title uppercase">العميل</h2>
                    <p class="invoice-desc">{{ $order->user->full_name }}</p>
                </div>
                <div class="col-xs-3">
                    <h2 class="invoice-title uppercase">البريد</h2>
                    <p class="invoice-desc">{{ $order->user->email }}</p>
                </div>
                <div class="col-xs-3">
                    <h2 class="invoice-title uppercase">الهاتف</h2>
                    <p class="invoice-desc">
                        {{ $order->user->mobile }}
                    </p>
                </div>
                <div class="col-xs-3">
                    <h2 class="invoice-title uppercase">التاريخ</h2>
                    <p class="invoice-desc">{{ dateFormat($order->created_at) }}</p>
                </div>
            </div>
            <div class="row invoice-body">
                <h2>تفاصيل الطلب</h2>
                <div class="col-xs-12 table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="invoice-title uppercase text-center">المنتج </th>
                                <th class="invoice-title uppercase text-center">السعر</th>
                                <th class="invoice-title uppercase text-center">الكمية</th>
                                <th class="invoice-title uppercase text-center">المجموع</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->details as $item)
                            <tr>
                                <td class="text-center sbold">
                                    <span>{{ $item->product->name_ar }}</span>
                                </td>
                                <td class="text-center sbold">
                                    {{ Price($item->price) }}
                                    <span> KD</span>
                                </td>
                                <td class="text-center sbold">{{ $item->qty }}</td>
                                <td class="text-center sbold">
                                    {{Price($item->price * $item->qty)}}
                                    <span> KD</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row invoice-body">
                <h2>العنوان</h2>
                <div class="col-xs-12 table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="invoice-title uppercase text-center">المحافظة</th>
                                <th class="invoice-title uppercase text-center">المنطقة</th>
                                <th class="invoice-title uppercase text-center">القطعة</th>
                                <th class="invoice-title uppercase text-center">الشارع</th>
                                <th class="invoice-title uppercase text-center">المبنى</th>
                                <th class="invoice-title uppercase text-center">العنوان</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center sbold">
                                    {{ $order->preview->address->addressProvince->governorate->name_ar }} <br>
                                </td>
                                <td class="text-center sbold">
                                    {{ $order->preview->address->addressProvince->name_ar }} <br>
                                </td>
                                <td class="text-center sbold">
                                    {{ $order->preview->address->block }}
                                </td>
                                <td class="text-center sbold">
                                    {{ $order->preview->address->street }}
                                </td>
                                <td class="text-center sbold">
                                    {{ $order->preview->address->building }}
                                </td>
                                <td class="text-center sbold">
                                    {{ $order->preview->address->address }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="row invoice-subtotal">
                <div class="col-xs-3">
                    <h2 class="invoice-title uppercase">المجموع الكلي</h2>
                    <p class="invoice-desc grand-total">
                        {{ Price($order->total) }} KD
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <a class="btn btn-lg green-haze hidden-print uppercase print-btn"
                    onclick="javascript:window.print();">طباعة</a>
                    <a class="btn btn-lg red-haze hidden-print uppercase"
                    href="{{ url(route('orders.index')) }}">للخلف</a>
                </div>
            </div>
        </div>
        
        
        <div class="no-print">
            <form method="POST" action="{{url(route('orders.update',$order['id']))}}"
                enctype="multipart/form-data" id="updateForm">
                
                {{ csrf_field() }}
                
                <input name="_method" type="hidden" value="PUT">
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                تغير حالة الطلب
                                <span class="required">*</span>
                            </label>
                            <select name="order_status_id" id="" class="form-control">
                                @foreach ($statuses as $status)
                                <option value="{{ $status['id'] }}"
                                    @if ($order->order_status_id == $status->id)
                                    selected
                                    @endif>
                                    {{ $status['name_ar'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div id="result" style="display: none"></div>
                <div class="progress-info" style="display: none">
                    <div class="progress">
                        <span class="progress-bar progress-bar-warning"></span>
                    </div>
                    <div class="status" id="progress-status"></div>
                </div>
                <div class="form-group">
                    <button type="submit" id="submit" class="btn green btn-lg">
                    تعديل
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop