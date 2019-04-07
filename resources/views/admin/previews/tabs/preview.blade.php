<div class="tab-pane active" id="preview">
    <div class="invoice">
        <div class="row invoice-logo">
            <div class="col-xs-6 invoice-logo-space">
                <img src="{{ url(settings('logo')) }}" class="img-responsive" style="width: 100px;"/>
            </div>
            <div class="col-xs-6">
                <p> #{{ $preview['id'] }} /
                    {{ date('Y-m-d',strtotime($preview->created_at)) }}
                </p>
            </div>
        </div>
        <hr/>
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
                            <td class="text-center sbold"> {{ $preview->user->name }}</td>
                            <td class="text-center sbold"> {{ $preview->user->email }}</td>
                            <td class="text-center sbold"> {{ $preview->user->mobile }}</td>
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
        <hr/>
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
                            <td class="text-center sbold"> {{ $preview->time }} </td>
                            <td class="text-center sbold"> {{ $preview->note }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="well">
                    <address>
                        المحافظة : {{ $preview->address->addressProvince->governorate->name_ar }}
                        <br/> المنطقة : {{ $preview->address->addressProvince->name_ar }}
                        <br/> قطعة : {{ $preview->address->block }}
                        <br/> شارع : {{ $preview->address->street }}
                        <br/> مبنى : {{ $preview->address->building }}
                        <br>
                    </address>
                    <address>
                        تفاصيل العنوان {{ $preview->address->address }}
                    </address>
                </div>
                <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> طباعة
                    <i class="fa fa-print"></i>
                </a>
            </div>
        </div>
    </div>
</div>