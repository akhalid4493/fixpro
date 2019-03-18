<div class="tab-pane" id="preview">
    <div class="invoice-content-2 bpreviewed">
        
        <div class="row invoice-head">
            <div class="col-md-7 col-xs-6">
                <div class="invoice-logo" style="text-align: right;">
                    <h3 class="blod uppercase">{{ settings(makeTrans('app_name')) }}</h3>
                </div>
            </div>
            <div class="col-md-5 col-xs-6">
                <div class="company-address">
                    <h3 class="bold uppercase">#{{ $order->preview['id'] }}</h3>
                </div>
            </div>
        </div>
        <div class="row invoice-cust-add">
            <div class="col-xs-3">
                <h2 class="invoice-title uppercase">العميل</h2>
                <p class="invoice-desc">{{ $order->preview->user->name }}</p>
            </div>
            <div class="col-xs-3">
                <h2 class="invoice-title uppercase">البريد</h2>
                <p class="invoice-desc">{{ $order->preview->user->email }}</p>
            </div>
            <div class="col-xs-3">
                <h2 class="invoice-title uppercase">الهاتف</h2>
                <p class="invoice-desc">
                    {{ $order->preview->user->mobile }}
                </p>
            </div>
            <div class="col-xs-3">
                <h2 class="invoice-title uppercase">التاريخ</h2>
                <p class="invoice-desc">{{ dateFormat($order->preview->created_at) }}</p>
            </div>
        </div>
        <div class="row invoice-body">
            <h2>تفاصيل الطلب</h2>
            <div class="col-xs-12 table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase text-center">الخدمة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->preview->details as $service)
                        <tr>
                            <td class="text-center sbold">
                                <span>{{ $service->service->name_ar }}</span>
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
        <div class="row invoice-body">
            <h2>المواعيد</h2>
            <div class="col-xs-12 table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase text-center">موعد طلب المعاينة</th>
                            <th class="invoice-title uppercase text-center">ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center sbold">
                                {{ $order->preview->time }}
                            </td>
                            <td class="text-center sbold">
                                {{ $order->preview->note }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        @if (!empty($order->preview->image))
        <div class="row invoice-body">
            <h2>صورة طلب المعاينة</h2>
            <div class="col-xs-12">
                <td class="text-center sbold">
                    <img src="{{ url($order->preview->image) }}" style="max-width: 100%">
                </td>
            </div>
        </div>
        <br>
        @endif
        
        <div class="row">
            <div class="col-xs-12">
                <a class="btn btn-lg green-haze hidden-print uppercase print-btn"
                onclick="javascript:window.print();">طباعة</a>
                <a class="btn btn-lg red-haze hidden-print uppercase"
                href="{{ url(route('previews.index')) }}">للخلف</a>
            </div>
        </div>
    </div>
</div>