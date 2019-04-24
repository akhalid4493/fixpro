<div class="tab-pane active" id="general">
    <div class="form-body">
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">
                        باقات الاشتراك
                        <span class="required">*</span>
                    </label>
                    <select name="package_id" id="single" class="form-control select2" disabled="">
                        <option></option>
                        @foreach ($packages as $package)
                        <option value="{{$package->id}}"
                            @if ($subscription['package_id'] == $package['id'])
                            selected=""
                            @endif>
                            {{transText($package,'name')}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">
                        اختر العضو
                        <span class="required">*</span>
                    </label>
                    <select name="user_id" id="single" class="form-control select2" disabled="">
                        <option></option>
                        @foreach ($users as $user)
                        <option value="{{$user->id}}"
                            @if ($subscription['user_id'] == $user['id'])
                            selected=""
                            @endif>
                            {{$user->name}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">
                        السعر الكلي للاشتراك
                        <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control" name="total" value="{{ number_format($subscription->total,3)}}" disabled="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">
                        التفعيل
                        <span class="required">*</span>
                    </label><br>
                    <label class="mt-radio mt-radio-outline"> مفعل
                        <input type="radio" name="status" value="1"
                        @if ($subscription->status == 1) checked="true" @endif>
                        <span></span>
                    </label>
                    <label class="mt-radio mt-radio-outline"> غير مفعل
                        <input type="radio" name="status" value="0"
                        @if ($subscription->status == 0) checked="true" @endif>
                        <span></span>
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">
                        يبدا الاشتراك
                        <span class="required">*</span>
                    </label>
                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                        <input type="text" class="form-control" name="start_at" value="{{ $subscription->start_at }}" disabled="">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">
                        ينتهي الاشتراك
                        <span class="required">*</span>
                    </label>
                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                        <input type="text" class="form-control" name="end_at" value="{{ $subscription->end_at }}" disabled="">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">
                        الدفعة القادمة
                    </label>
                    <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                        <input type="text" class="form-control" name="next_billing" value="{{ $subscription->next_billing }}">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                            <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">
                        ملاحطات
                        <span class="required">*</span>
                    </label>
                    <textarea class="form-control" name="note" id="" cols="30" rows="10">{{ $subscription->note }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>