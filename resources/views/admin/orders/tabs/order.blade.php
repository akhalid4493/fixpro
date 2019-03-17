<div class="tab-pane active" id="order">
    <div class="invoice-content-2 bordered">
        
        <div class="row invoice-head">
            <div class="col-md-7 col-xs-6">
                <div class="invoice-logo" style="text-align: right;">
                    <h3 class="blod uppercase">{{ settings(makeTrans('app_name')) }}</h3>
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
                <p class="invoice-desc">{{ $order->user->name }}</p>
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
            <h2>تفاصيل القطع الاستهلاكية</h2>
            <div class="col-xs-12 table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase text-center">المنتج </th>
                            <th class="invoice-title uppercase text-center">السعر</th>
                            <th class="invoice-title uppercase text-center">الكمية</th>
                            <th class="invoice-title uppercase text-center">المجموع</th>
                            <th class="invoice-title uppercase text-center">انتهاء الكفالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->productsOfOrder as $item)
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
                            <td class="text-center sbold">
                                {{ $item->warranty_end }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row invoice-body">
            <h2>تفاصيل تركيب القطع</h2>
            <div class="col-xs-12 table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase text-center">المنتج </th>
                            <th class="invoice-title uppercase text-center">السعر</th>
                            <th class="invoice-title uppercase text-center">الكمية</th>
                            <th class="invoice-title uppercase text-center">المجموع</th>
                            <th class="invoice-title uppercase text-center">انتهاء الكفالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->installationsOfOrder as $installation)
                        <tr>
                            <td class="text-center sbold">
                                <span>{{ $installation->installation->name_ar }}</span>
                            </td>
                            <td class="text-center sbold">
                                {{ Price($installation->price) }}
                                <span> KD</span>
                            </td>
                            <td class="text-center sbold">{{ $installation->qty }}</td>
                            <td class="text-center sbold">
                                {{Price($installation->price * $installation->qty)}}
                                <span> KD</span>
                            </td>
                            <td class="text-center sbold">
                                {{ $installation->warranty_end }}
                            </td>
                        </tr>
                        @endforeach
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
        <div class="row">
            <div class="col-xs-12">
                <a class="btn btn-lg green-haze hidden-print uppercase print-btn"
                onclick="javascript:window.print();">طباعة</a>
                <a class="btn btn-lg red-haze hidden-print uppercase"
                href="{{ url(route('orders.index')) }}">للخلف</a>
            </div>
        </div>
    </div>
</div>