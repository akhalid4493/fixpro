<div class="tab-pane active" id="order">
    <div class="invoice">
        <div class="row invoice-logo">
            <div class="col-xs-6 invoice-logo-space">
                <img src="{{ url(settings('logo')) }}" class="img-responsive" style="width: 100px;" />
            </div>
            <div class="col-xs-6">
                <p> #{{ $order['id'] }} /
                    {{ date('Y-m-d',strtotime($order->created_at)) }}
                </p>
            </div>
        </div>
        <hr />
        <div class="row">
            <h3>بيانات العميل</h3>
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase text-center"> الاسم</th>
                            <th class="invoice-title uppercase text-center"> البريد الالكتروني </th>
                            <th class="invoice-title uppercase text-center"> الهاتف </th>
                            <th class="invoice-title uppercase text-center"> حالة العميل </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center sbold"> {{ $order->user->name }}</td>
                            <td class="text-center sbold"> {{ $order->user->email }}</td>
                            <td class="text-center sbold"> {{ $order->user->mobile }}</td>
                            @if ($order->user->checkSubscription == true)
                            <td class="text-center sbold">
                                <span class="label label-success circle" style="font-size:13px">
                                    مشترك
                                </span>
                            </td>
                            @else
                            <td class="text-center sbold">
                                <span class="label label-danger circle" style="font-size:13px">
                                    غير مشترك
                                </span>
                            </td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <h3>تفاصيل القطع الاستهلاكية</h3>
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase text-center"> # </th>
                            <th class="invoice-title uppercase text-center">المنتج </th>
                            <th class="invoice-title uppercase text-center">السعر</th>
                            <th class="invoice-title uppercase text-center no-print">سعر الربح</th>
                            <th class="invoice-title uppercase text-center">الكمية</th>
                            <th class="invoice-title uppercase text-center">المجموع</th>
                            <th class="invoice-title uppercase text-center no-print">مجموع الربح</th>
                            <th class="invoice-title uppercase text-center">انتهاء الكفالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->productsOfOrder as $key => $item)
                        <tr>
                            <td class="text-center sbold"> {{ ++$key }} </td>
                            <td class="text-center sbold">
                                <span>{{ $item->product->name_ar }}</span>
                            </td>
                            <td class="text-center sbold">
                                {{ Price($item->price) }}
                                <span> KD</span>
                            </td>
                            <td class="text-center sbold no-print">
                                <span class="label label-success" style="font-size: 13px">
                                    {{Price($item->profit_price)}}
                                    <span> KD</span>
                                </span>
                            </td>
                            <td class="text-center sbold">{{ $item->qty }}</td>
                            <td class="text-center sbold">
                                {{Price($item->total)}}
                                <span> KD</span>
                            </td>

                            <td class="text-center sbold no-print">
                                <span class="label label-success" style="font-size: 13px">
                                    {{Price($item->profit_total)}}
                                    <span> KD</span>
                                </span>
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
        <hr>
        <div class="row">
            <h3>تفاصيل تركيب القطع الاستهلاكية</h3>
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase text-center"> # </th>
                            <th class="invoice-title uppercase text-center">المنتج </th>
                            <th class="invoice-title uppercase text-center">السعر</th>
                            <th class="invoice-title uppercase text-center">الكمية</th>
                            <th class="invoice-title uppercase text-center">المجموع</th>
                            <th class="invoice-title uppercase text-center">انتهاء الكفالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->installationsOfOrder as $key => $installation)
                        <tr>
                            <td class="text-center sbold"> {{ ++$key }} </td>
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
        <hr />
        <div class="row">
            <div class="col-xs-4">
                <div class="well">
                    @if ($order->preview->address != null)
                    <address>
                        المحافظة : {{ $order->preview->address->addressProvince->governorate->name_ar }}
                        <br /> المنطقة : {{ $order->preview->address->addressProvince->name_ar }}
                        <br /> قطعة : {{ $order->preview->address->block }}
                        <br /> شارع : {{ $order->preview->address->street }}
                        <br /> مبنى : {{ $order->preview->address->building }}
                        <br>
                    </address>
                    <address>
                        تفاصيل العنوان {{ $order->preview->address->address }}
                    </address>
                    @else
                    <address>
                        المحافظة : {{ $order->preview->oldAddress->addressProvince->governorate->name_ar }}
                        <br /> المنطقة : {{ $order->preview->oldAddress->addressProvince->name_ar }}
                        <br /> قطعة : {{ $order->preview->oldAddress->block }}
                        <br /> شارع : {{ $order->preview->oldAddress->street }}
                        <br /> مبنى : {{ $order->preview->oldAddress->building }}
                        <br>
                    </address>
                    <address>
                        تفاصيل العنوان {{ $order->preview->oldAddress->address }}
                    </address>
                    @endif
                </div>
            </div>
            <div class="no-print">
                <div class="col-xs-4 invoice-block">
                    <ul class="list-unstyled amounts">
                        <li>
                            <strong>مجموع الربح :</strong> {{ Price($order->subtotal_profit) }} KWD
                        </li>
                        <li>
                            <strong>الخدمة :</strong> {{ Price($order->service) }} KWD
                        </li>
                        <hr>
                        <li>
                            <strong>المجموع الكلي للربح :</strong> {{ Price($order->total_profit) }} KWD
                        </li>
                    </ul>
                    <br/>
                </div>
            </div>
            <div class="col-xs-4 invoice-block">
                <ul class="list-unstyled amounts">
                    <li>
                        <strong>المجموع :</strong> {{ Price($order->subtotal) }} KWD
                    </li>
                    <li>
                        <strong>الخدمة :</strong> {{ Price($order->service) }} KWD
                    </li>
                    <hr>
                    <li>
                        <strong>المجموع الكلي :</strong> {{ Price($order->total) }} KWD
                    </li>
                </ul>
                <br />
            </div>
        </div>

        <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> طباعة
            <i class="fa fa-print"></i>
        </a>

    </div>
</div>
