<div class="tab-pane active" id="global_setting">

    <div class="form-body">
        <div class="form-group">
            <label class="col-md-2 control-label">
                العنوان [en]
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="app_name_en"
                value="{{settings('app_name_en')}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">
                العنوان [ar]
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="app_name_ar"
                value="{{settings('app_name_ar')}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">
                كفالة التركيب بالايام
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="warranty"
                value="{{settings('warranty')}}"/>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">
                سعر الخدمة KWD
            </label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="service"
                value="{{settings('service')}}"/>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane" id="emails">
    <div class="form-group">
        <label class="col-md-2 control-label">
            استقبال الرسائل على
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="receive_mail"
            value="{{settings('receive_mail')}}"/>
        </div>
    </div>
</div>
<div class="tab-pane" id="contact_info">
    <div class="form-group">
        <label class="col-md-2 control-label">
            رقم الهاتف
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="company_contact"
            value="{{settings('company_contact')}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            العنوان
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="company_address"
            value="{{settings('company_address')}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            البريد الالكتروني
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="company_email"
            value="{{settings('company_email')}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            Ios App Link
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="ios_app"
            value="{{settings('ios_app')}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            Android App Link
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="android_app"
            value="{{settings('android_app')}}"/>
        </div>
    </div>
</div>
<div class="tab-pane" id="logo">
    <div class="form-group">
        <label class="col-md-2 control-label">
            Logo
        </label>
        <div class="col-md-10">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                    <img src="{{ url(settings('logo')) }}" alt="logo" style="max-width: 67%" />
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                </div>
                <div>
                    <input type="file" name="logo" class="form-control">
                    <input type="hidden" name="old_logo" value="{{settings('logo')}}">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="col-md-2 control-label">
            Favicon
        </label>
        <div class="col-md-10">
            <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                    <img src="{{ url(settings('favicon')) }}" alt="favicon Icon" style="max-width: 67%" />
                </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                </div>
                <div>
                    <input type="file" name="favicon" class="form-control">
                    <input type="hidden" name="old_favicon" value="{{settings('favicon')}}">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane" id="social">
    <div class="form-group">
        <label class="col-md-2 control-label">
            Facebook Link
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="facebook"
            value="{{settings('facebook')}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            Twitter Link
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="twitter"
            value="{{settings('twitter')}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            Linkedin Link
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="linkedin"
            value="{{settings('linkedin')}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            Google+ Link
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="google_plus"
            value="{{settings('google_plus')}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">
            Instagram Link
        </label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="instagram"
            value="{{settings('instagram')}}"/>
        </div>
    </div>
</div>
<div class="tab-pane" id="other">
    <div class="form-body">
        <div class="form-group">
            <label class="col-md-2 control-label">
                الشروط و الاحكام [ar]
            </label>
            <div class="col-md-10">
                <textarea class="form-control ckeditor" name="terms_ar" cols="30" rows="10">{!!settings('terms_ar')!!}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">
                الشروط و الاحكام [en]
            </label>
            <div class="col-md-10">
                <textarea class="form-control ckeditor" name="terms_en" cols="30" rows="10">{!!settings('terms_en')!!}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">
                سياسة الخصوصية [ar]
            </label>
            <div class="col-md-10">
                <textarea class="form-control ckeditor" name="policy_ar" cols="30" rows="10">{!!settings('policy_ar')!!}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label">
                سياسة الخصوصية [en]
            </label>
            <div class="col-md-10">
                <textarea class="form-control ckeditor" name="policy_en" cols="30" rows="10">{!!settings('policy_en')!!}</textarea>
            </div>
        </div>
    </div>
</div>
<div class="tab-pane" id="force_update">
  <div class="form-group">
    <label class="control-label col-md-3">
      تحديث ضروري
      <span class="required">*</span>
    </label>
    <div class="col-md-9">
      <div class="mt-radio-inline">
        <label class="mt-radio mt-radio-outline"> يوجد
          <input type="radio" name="force_update" value="1"
          @if (settings('force_update') == 1)
            checked
          @endif>
          <span></span>
        </label>
        <label class="mt-radio mt-radio-outline">
          لا يوجد
          <input type="radio" name="force_update" value="0"
          @if (settings('force_update') == 0)
            checked
          @endif>
          <span></span>
        </label>
      </div>
    </div>
  </div>
</div>
