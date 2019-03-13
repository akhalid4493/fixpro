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