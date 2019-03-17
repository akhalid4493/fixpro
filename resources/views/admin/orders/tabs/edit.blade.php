<div class="tab-pane" id="edit">
    <div class="no-print">
        <form method="POST" action="{{url(route('orders.update',$order['id']))}}"
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
                        <select name="order_status_id" id="" class="form-control">
                            @foreach ($statuses as $status)
                            <option value="{{ $status['id'] }}"
                                @if ($order->order_status_id == $status->id)
                                selected
                                @endif>
                                {{ $status['name_ar'] }}
                            </option>
                            @endforeach
                        </select>
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