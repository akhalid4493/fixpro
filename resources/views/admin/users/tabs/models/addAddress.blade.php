{{-- ADD MODAL --}}
<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet light bordered">
              <div class="portlet-title">
                <div class="caption font-red-sunglo">
                  <i class="icon-settings font-red-sunglo"></i>
                  <span class="caption-subject bold uppercase"> اضافة عنوان جديد
                  </span>
                </div>
              </div>
              <div class="portlet-body form">
                <form id="form" method="POST" action="{{url(route('addresses.store'))}}"
                  enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div class="form-body">
                    <div class="form-group">
                      <label class="control-label">
                        المدينة
                      </label>
                      <select id="single" name="province_id" class="form-control select">
                        @foreach ($governorates as
                        $governorate)
                        <optgroup label="- {{$governorate->name_ar}}">
                          @foreach ($governorate->province as $province)
                          <option value="{{$province->id}}">
                            {{ $province['name_ar'] }}
                          </option>
                          @endforeach
                        </optgroup>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>القطعة
                      </label>
                      <input type="text" name="block" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>الشارع
                      </label>
                      <input type="text" name="street" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>المنزل
                      </label>
                      <input type="text" name="building" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>الدور
                      </label>
                      <input type="text" name="floor" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>الشقة
                      </label>
                      <input type="text" name="house_no" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>العنوان بالتفاصيل
                      </label>
                      <textarea name="address" class="form-control" id="" cols="30" rows="10"></textarea>
                    </div>
                  </div>
                  <input type="hidden" name="user_id" class="form-control" value="{{ $user->id }}">
                  <div id="result" style="display: none"></div>
                  <div class="progress-info" style="display: none">
                    <div class="progress"><span class="progress-bar progress-bar-warning"></span></div>
                    <div class="status" id="progress-status"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" id="submit" class="btn btn-primary">اضافة</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">الرجوع للخلف</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
