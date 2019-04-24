<div class="tab-pane active" id="general">
    <div class="portlet light profile-sidebar-portlet ">
        <div class="profile-userpic">
            <img src="{{ url($user->image) }}" class="img-responsive" alt="" style="width: 10%">
        </div>
        <div class="profile-usertitle">
            <div class="profile-usertitle-name"> {{ $user->name }} </div>
        </div>
        <div class="profile-userbuttons">
            {!! Status($user->active) !!}
        </div>
        <div class="profile-userbuttons">
            <ul class="list-inline">
                <li>
                    <i class="fa fa-calendar"></i>
                    تم التسجيل : {{ date("d-m-Y", strtotime($user->created_at)) }}
                </li>
                <li>
                <i class="fa fa-envelope"></i> {{ $user->email }} </li>
                <li>
                <i class="fa fa-phone"></i> {{ $user->mobile }} </li>
            </ul>
        </div>
        <div class="profile-usermenu">
        </div>
    </div>
    <div class="portlet light ">
        <div class="row list-separated profile-stat">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="uppercase profile-stat-title"> {{ count($user->previews) }} </div>
                <div class="uppercase profile-stat-text"> طلبات المعاينة </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="uppercase profile-stat-title"> {{ count($user->orders) }} </div>
                <div class="uppercase profile-stat-text"> الطلبات  </div>
            </div>
        </div>
        <div class="profile-userbuttons">
            <h4 class="profile-desc-title">الاشتراك</h4>
            @if ($user->hasSubscription)
            <span class="label label-success">مشترك</span>
            
            <div class="margin-top-20 profile-desc-link">
                <i class="fa fa-calendar"></i>
                بدء الاتشراك : {{ $user->hasSubscription->start_at }}
            </div>
            <div class="margin-top-20 profile-desc-link">
                <i class="fa fa-calendar"></i>
                ينتهي الاتشراك : {{ $user->hasSubscription->end_at }}
            </div>
            <div class="margin-top-20 profile-desc-link">
                <i class="fa fa-usd"></i>
                مبلغ الاشتراك: {{ number_format($user->hasSubscription->total,3) }} KWD
            </div>
            <div class="margin-top-20 profile-desc-link">
                <i class="fa fa-usd"></i>
                المتبقي : {{ billingRemender($user->hasSubscription) }} KWD
            </div>
            @elseif($user->hasSubscription && $user->hasSubscription->end_at > date('Y-m-d'))
                <span class="label label-warning">انتهى الاشتراك</span>
            @else
                <span class="label label-danger">غير الاشتراك</span>
            @endif
        </div>
    </div>
</div>