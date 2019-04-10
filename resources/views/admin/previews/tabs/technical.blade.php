<div class="tab-pane" id="technical">
    <form id="updateForm" method="POST" action="{{url(route('previews.update',$preview['id']))}}"
        enctype="multipart/form-data" class="horizontal-form">
        <div class="no-print">
            @csrf
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="preview_id" value="{{ $preview['id'] }}">
            <input type="hidden" name="status"     value="{{ $preview['preview_status_id'] }}">
            <input type="hidden" name="province_id" value="{{$preview->address->addressProvince->id}}">
            
            <div class="row">
                @foreach ($preview->details as $detail)
                
                <input type="hidden" name="service_id[]" value="{{ $detail->service_id }}">
                <div class="col-lg-6 col-xs-12 col-sm-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <i class="icon-bubbles font-dark hide"></i>
                                <span class="caption-subject font-dark bold uppercase">
                                    اسناد فني لخدمة " {{ $detail->service->name_ar }} "
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="mt-comments">
                                @foreach (Preview::technicalOfService($preview) as $technical)
                                <div class="mt-comment">
                                    <div class="mt-comment-img">
                                        <img src="{{ url($technical->image) }}" style="max-width: 48px;"/>
                                    </div>
                                    <div class="mt-comment-body">
                                        <div class="mt-comment-info">
                                            <span class="mt-comment-author">
                                                {{ $technical->name }}
                                            </span>
                                        </div>
                                        <div class="mt-comment-text">
                                            <li>المناطق التي يخدمها :
                                                @foreach ($technical->locationsOfTechnical as $location)
                                                {{ $loop->first ? '' : ' , ' }}
                                                {{ $location->name_ar }}
                                                @endforeach
                                            </li>
                                            <li>ايام العمل :
                                                @foreach ($technical->workDays as $day)
                                                {{ $loop->first ? '' : ' , ' }}
                                                {{ $day->day }}
                                                @endforeach
                                            </li>
                                            <li>الخدمات التي يعمل بها :
                                                @foreach ($technical->servicesOfTechnical as $service)
                                                {{ $loop->first ? '' : ' , ' }}
                                                {{ $service->name_ar }}
                                                @endforeach
                                            </li>
                                            <li>يبدا دوام من  : {{ $technical->shift->from }}</li>
                                            <li>ينتهي دوام في : {{ $technical->shift->to }}</li>
                                            @if (Preview::previewInSameDate($technical,$preview))
                                            <li class="alert alert-danger">
                                                يمتلك الفني طلب معاينة اخرة في نفس الموعد
                                            </li>
                                            @endif
                                        </div>
                                        @if (!Preview::previewInSameDate($technical,$preview))
                                        <div class="mt-comment-details">
                                            <div class="form-group">
                                                <div class="mt-radio-inline">
                                                    <label class="mt-radio mt-radio-outline">
                                                        <input type="radio" name="technical[]"
                                                        value="{{ $technical->id }}"
                                                        @if ($preview->technical)
                                                        @if ($technical->id == $preview->technical->user_id)
                                                        checked=""
                                                        @endif
                                                        @endif>
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <hr>
            <div class="row">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                موعد طلب المعاينة
                                <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <input autocomplete="off" type="text" class="form-control timepicker timepicker-24" name="time" value="{{Preview::hourOfPreview($preview->time)}}">
                                <span class="input-group-btn">
                                    <button class="btn default"type="button">
                                    <i class="fa fa-clock-o"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                تاريخ طلب المعاينة
                                <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                <input type="text" class="form-control" name="date" value="{{Preview::dateOfPreview($preview->time)}}">
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
                                تغير حالة الطلب
                                <span class="required">*</span>
                            </label>
                            <select name="preview_status_id" id="single" class="form-control select2">
                                @foreach ($statuses as $status)
                                <option value="{{ $status['id'] }}"
                                    @if ($preview->preview_status_id == $status->id)
                                    selected
                                    @endif>
                                    {{ $status['name_ar'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="mt-checkbox-list">
                                <label class="mt-checkbox">
                                    <input type="checkbox" name="user_notifi" value="1">
                                    ارسال اشعار للمستخدم
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="mt-checkbox-list">
                                <label class="mt-checkbox">
                                    <input type="checkbox" name="tech_notifi" value="1">
                                    ارسال اشعار للفني
                                    <span></span>
                                </label>
                            </div>
                        </div>
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
        </div>
    </form>
</div>