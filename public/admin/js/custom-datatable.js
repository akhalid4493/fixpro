$(document).ready(function(){

    tableGenerate();

    $('#search').click(function(){

        var $form = $("#formFilter");
        var data = getFormData($form);

        console.log(data);

        $('#dataTable').DataTable().destroy();

        tableGenerate(data);

    });

    $('.filter-cancel').click(function(){

        document.getElementById("formFilter").reset();

        $('#dataTable').DataTable().destroy();

        tableGenerate();

    });
});

$('.chkParent').click(function() {

    var isChecked = $('input[name=ids]').first().prop('checked');
    $('input[name=ids]').prop('checked', ! isChecked );

});

function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}


$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        if (start.isValid()&& end.isValid()) {
            $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            $('input[name="from"]').val(start.format('YYYY-MM-DD'));
            $('input[name="to"]').val(end.format('YYYY-MM-DD'));
        }else{
            $('#reportrange span').html('الغاء التاريخ');
            $('input[name="from"]').val('');
            $('input[name="to"]').val('');
        }
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'الغاء التاريخ' : [null],
           'اليوم'         : [moment(), moment()],
           'الآمس'          : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'اخر ٧ ايام'    : [moment().subtract(6, 'days'), moment()],
           'اخر ٣٠ يوم'    : [moment().subtract(29, 'days'), moment()],
           'هذا الشهر'     : [moment().startOf('month'), moment().endOf('month')],
           'الشهر السابق'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        },
        opens: 'left',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn btn-primary',
          cancelClass: 'btn-small btn btn-danger',
          format: 'YYYY-MM-DD',
          separator: 'to',
          locale: {
              applyLabel: 'حفظ',
              cancelLabel: 'الغاء',
              fromLabel: 'من',
              toLabel: 'الى',
              customRangeLabel: 'ترتيب خاص',
              firstDay: 1
          }
    }, cb);

    cb(start, end);

});
