<div class="tab-pane" id="preview">
    <div class="invoice">
        <div class="row invoice-logo">
            <div class="col-xs-6 invoice-logo-space">
                <img src="{{ url(settings('logo')) }}" class="img-responsive" style="width: 100px;" />
            </div>
            <div class="col-xs-6">
                <p> #{{ $order->preview['id'] }} /
                    {{ date('Y-m-d',strtotime($order->preview->created_at)) }}
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td class="text-center sbold">
                                <a href="{{url(route('users.show',$order->preview->user->id))}}">
                                    {{ $order->preview->user->name }}
                                </a>
                            </td>
                            <td class="text-center sbold"> {{ $order->preview->user->email }}</td>
                            <td class="text-center sbold"> {{ $order->preview->user->mobile }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <h3>تفاصيل الطلب</h3>
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase text-center"> # </th>
                            <th class="invoice-title uppercase text-center"> الخدمة المطلوبة </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->preview->details as $key => $service)
                        <tr>
                            <td class="text-center sbold"> {{ ++$key }} </td>
                            <td class="text-center sbold"> {{ $service->service->name_ar }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr />
        <div class="row">
            <h3>بيانات اضافية</h3>
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase text-center"> موعد المعاينة المطلوب</th>
                            <th class="invoice-title uppercase text-center"> ملاحظات </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center sbold"> {{ $order->preview->time }} </td>
                            <td class="text-center sbold"> {{ $order->preview->note }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
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
                <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> طباعة
                    <i class="fa fa-print"></i>
                </a>
            </div>
        </div>
    </div>
</div>
