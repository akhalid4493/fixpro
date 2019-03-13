<div class="tab-pane" id="edit">
    <div class="no-print">
        <form method="POST" action="{{url(route('previews.update',$preview['id']))}}"
            enctype="multipart/form-data" id="updateForm">
            
            {{ csrf_field() }}
            
            <input name="_method" type="hidden" value="PUT">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            تغير حالة الطلب
                            <span class="required">*</span>
                        </label>
                        <select name="preview_status_id" id="" class="form-control">
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            اسناد طلب المعاينة الى
                            <span class="required">*</span>
                        </label>
                        <select name="techincal_user_id" id="" class="form-control">
                            <option value="">اختر الموظف</option>
                            @foreach ($users as $user)
                            <option value="{{ $user['id'] }}"
                                @if ($preview->technical)
                                @if ($user['id']==$preview->technical->user_id)
                                selected=""
                                @endif
                                @endif
                                >
                                {{ $user['name'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
        </form>
    </div>
</div>