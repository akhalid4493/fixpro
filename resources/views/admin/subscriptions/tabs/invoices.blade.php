<div class="tab-pane" id="invoices">
    <div class="billingForm">
        @forelse ($subscription->monthlyBilling as $billing)
        <div class="form-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            قيمة الفاتورة
                            <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" name="price[]" value="{{ number_format($billing->price,3) }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">
                            تم دفع هذة الفاتوره بتاريخ
                            <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="paid_at[]" placeholder="2019-05-01" value="{{ $billing->paid_at }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">
                            حذف
                        </label>
                        <div class="">
                            <a href="#" class="removeBillingForm btn red">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="form-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            قيمة الفاتورة
                            <span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" name="price[]">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">
                            تم دفع هذة الفاتوره بتاريخ
                            <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="paid_at[]" placeholder="2019-05-01">
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">
                            حذف
                        </label>
                        <div class="">
                            <a href="#" class="removeBillingForm btn red">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>
    <div class="form-group">
        <div class="col-md-6">
            <button type="button" class="btn green btn-lg mt-ladda-btn ladda-button btn-circle btn-outline addBillingForm" data-style="slide-down" data-spinner-color="#333">
            <span class="ladda-label">
                <i class="icon-plus"></i>
            </span>
            </button>
        </div>
    </div>
</div>
@section('scripts')
<script>
$(document).ready(function() {
    var html = $("div.billingForm").html();
    
    $(".addBillingForm").click(function(e){
        e.preventDefault();
        $(".billingForm").append(html);
    });
    
    $(".billingForm").on("click",".removeBillingForm", function(e){
        e.preventDefault();
        $(this).parent().parent().parent().parent().remove();
    })
});
</script>
@stop