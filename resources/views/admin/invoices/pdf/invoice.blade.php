<div class="tab-pane active" id="invoice">
    <div class="invoice">
        <div class="row invoice-logo">
            <div class="col-xs-6 invoice-logo-space">
                <img src="{{ url(settings('logo')) }}" class="img-responsive" style="width: 100px;"/>
            </div>
            <div class="col-xs-6">
                <p> #{{ $invoice['id'] }} /
                    {{ date('Y-m-d',strtotime($invoice->paid_at)) }}
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
                            <th class="invoice-title uppercase text-center"> حالة العميل </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center sbold"> {{$invoice->subscription->user->name }}</td>
                            <td class="text-center sbold"> {{$invoice->subscription->user->email }}</td>
                            <td class="text-center sbold"> {{$invoice->subscription->user->mobile }}</td>
                            @if ($invoice->subscription->user->checkSubscription == true)
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
        <hr/>
        <div class="row">
            <h3>بيانات الاشتراك</h3>
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="invoice-title uppercase text-center"> يبدا الاشتراك في</th>
                            <th class="invoice-title uppercase text-center"> ينتهي الاشتراك في</th>
                            <th class="invoice-title uppercase text-center"> تاريخ دفع هذة الدفعة في</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center sbold"> {{ $invoice->subscription->start_at }} </td>
                            <td class="text-center sbold"> {{ $invoice->subscription->end_at }} </td>
                            <td class="text-center sbold"> {{ $invoice->paid_at }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="well">
                    <address>
                        اجمالي سعر الاشتراك : {{ number_format($invoice->subscription->total,3) }} KWD
                    </address>

                    <address>
                        قيمة هذه الدفعة : {{ number_format($invoice->price,3) }} KWD
                    </address>
                    <address>
                        المتبقي : {{ billingRemender($invoice->subscription) }} KWD
                    </address>
                </div>
                <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> طباعة
                    <i class="fa fa-print"></i>
                </a>
            </div>
        </div>
    </div>
</div>