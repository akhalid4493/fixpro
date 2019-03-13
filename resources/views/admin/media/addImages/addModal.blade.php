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
                  <span class="caption-subject bold uppercase"> اضافة صور
                  </span>
                </div>
              </div>

              <div class="portlet-body form">

                <form id="form" method="POST" action="{{url(route('media.store'))}}"
                      enctype="multipart/form-data">
                  {{ csrf_field() }}

                  <div class="form-body">
                    <div class="form-group">
                      <label>الصور <span class="required">*</span></label>
                      <input type="file" name="image[]" class="form-control" required="" multiple>
                    </div>
                  </div>
                    
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