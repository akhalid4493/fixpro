<div class="tab-pane active" id="preview">
    <div class="invoice">
        <div class="row invoice-logo">
            <div class="col-xs-6 invoice-logo-space">
                <img src="{{ url(settings('logo')) }}" class="img-responsive" style="width: 100px;" />
            </div>
            <div class="col-xs-6">
                <p> #{{ $preview['id'] }} /
                    {{ date('Y-m-d',strtotime($preview->created_at)) }}
                </p>
            </div>
        </div>
        <hr />
        <div class="no-print">
            <div class="row">
                <h3>المشاهدة</h3>
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="invoice-title uppercase text-center"> حالة المشاهدة </th>
                                <th class="invoice-title uppercase text-center"> تاريخ المشاهدة </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center sbold">
                                    @if ($preview->seen == 1)
                                    تم المشاهدة
                                    @endif
                                </td>
                                <td class="text-center sbold"> {{ $preview->seen_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                            <td class="text-center sbold">
                                <a href="{{url(route('users.show',$preview->user->id))}}">
                                    {{ $preview->user->name }}
                                </a>
                            </td>
                            <td class="text-center sbold"> {{ $preview->user->email }}</td>
                            <td class="text-center sbold"> {{ $preview->user->mobile }}</td>
                            @if ($preview->user->checkSubscription == true)
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
                        @foreach ($preview->details as $key => $service)
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
                            <th class="invoice-title uppercase text-center"> سعر المعاينة </th>
                            <th class="invoice-title uppercase text-center"> موعد المعاينة المطلوب</th>
                            <th class="invoice-title uppercase text-center"> ملاحظات </th>
                            <th class="invoice-title uppercase text-center"> ملاحظات الفني </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center sbold"> {{ $preview->total }} </td>
                            <td class="text-center sbold"> {{ $preview->time }} </td>
                            <td class="text-center sbold"> {{ $preview->note }}</td>
                            <td class="text-center sbold"> {{ $preview->note_from_technical }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="well">
                    @if ($preview->address != null)
                    <address>
                        المحافظة : {{ $preview->address->addressProvince->governorate->name_ar }}
                        <br /> المنطقة : {{ $preview->address->addressProvince->name_ar }}
                        <br /> قطعة : {{ $preview->address->block }}
                        <br /> شارع : {{ $preview->address->street }}
                        <br /> مبنى : {{ $preview->address->building }}
                        <br>
                    </address>
                    <address>
                        تفاصيل العنوان {{ $preview->address->address }}
                    </address>
                    @else
                    <address>
                        المحافظة : {{ $preview->oldAddress->addressProvince->governorate->name_ar }}
                        <br /> المنطقة : {{ $preview->oldAddress->addressProvince->name_ar }}
                        <br /> قطعة : {{ $preview->oldAddress->block }}
                        <br /> شارع : {{ $preview->oldAddress->street }}
                        <br /> مبنى : {{ $preview->oldAddress->building }}
                        <br>
                    </address>
                    <address>
                        تفاصيل العنوان {{ $preview->oldAddress->address }}
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
