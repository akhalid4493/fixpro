// ADD FORM
$('#form').on('submit',function(e) {

    e.preventDefault();

    var url     = $(this).attr('action');
    var method  = $(this).attr('method');
    
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }

    $.ajax({

        xhr: function() {
        var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
              if (evt.lengthComputable) {
                var percentComplete = evt.loaded / evt.total;
                percentComplete = parseInt(percentComplete * 100);
                $('.progress-bar').width(percentComplete+'%');
                $('#progress-status').html(percentComplete+'%');
              }
            }, false);
            return xhr;
        },

        url: url,
        type: method,
        dataType: 'JSON',
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        
        beforeSend : function(){
                $('#submit').html('<img src="/uploads/loading.gif" style="max-width: 12px;"> تحميل ...');
                $('#submit').prop('disabled',true);
                $('.progress-info').show();
                $('.progress-bar').width('0%');
            },        
        success:function(data){
            
            $('#submit').prop('disabled',false);
            $('#submit').html('اضافة');

            if (data[0] == true){
                toastr["success"](data[1]);
                $('#form')[0].reset();
            }
            else{
                console.log(data);
                toastr["error"](data[1]);
            }
            
            $('.progress-info').hide();
            $('.progress-bar').width('0%');

        },
       error: function(data){

            console.log(data);
        
            $('#submit').html('اضافة');
            $('#submit').prop('disabled',false);

            var getJSON = $.parseJSON(data.responseText);
            var output= "<div class='alert alert-danger'><ul>";
            for (var error in getJSON.errors){
                output += "<li>" + getJSON.errors[error] + "</li>";
            }
            output += "</ul></div>";

           $('#result').slideDown('fast', function(){
                $('#result').html(output);
                $('.progress-info').hide();
                $('.progress-bar').width('0%');
            }).delay(5000).slideUp('slow');           
        },
    });

});

// Update
$('#updateForm').on('submit',function(e) {

    e.preventDefault();

    var url     = $(this).attr('action');
    var method  = $(this).attr('method');
    
    for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
    
    $.ajax({

        xhr: function() {
        var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
              if (evt.lengthComputable) {
                var percentComplete = evt.loaded / evt.total;
                percentComplete = parseInt(percentComplete * 100);
                $('.progress-bar').width(percentComplete+'%');
                $('#progress-status').html(percentComplete+'%');
              }
            }, false);
            return xhr;
        },

        url: url,
        type: method,
        dataType: 'JSON',
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        
        beforeSend : function(){
                $('#submit').html('<img src="/uploads/loading.gif" style="max-width: 12px;"> تحميل ...');
                $('#submit').prop('disabled',true);
                $('.progress-info').show();
                $('.progress-bar').width('0%');
            },        
        success:function(data){
            $('#submit').prop('disabled',false);
            $('#submit').html('تعديل');

            if (data[0] == true){
                toastr["success"](data[1]);
            }
            else{
                console.log(data);
                toastr["error"](data[1]);
            }
            
            $('.progress-info').hide();
            $('.progress-bar').width('0%');
        },
       error: function(data){
            console.log(data);
            $('#submit').html('تعديل');
            $('#submit').prop('disabled',false);

            var getJSON = $.parseJSON(data.responseText);
            var output= "<div class='alert alert-danger'><ul>";
            for (var error in getJSON.errors){
                output += "<li>" + getJSON.errors[error] + "</li>";
            }
            output += "</ul></div>";

           $('#result').slideDown('fast', function(){
                $('#result').html(output);
                $('.progress-info').hide();
                $('.progress-bar').width('0%');
            }).delay(5000).slideUp('slow');           
        },
    });

});

// DELETE ROW FROM DATATABLE
function deleteRow(url)
{
    var _token  = $('input[name=_token]').val();  

    bootbox.confirm({
        message: "هل انت متآكد لحذف هذا الصف ؟",
        buttons: {
            confirm: {
                label: 'نعم',
                className: 'btn-success'
            },
            cancel: {
                label: 'لا',
                className: 'btn-danger'
            }
        },

        callback: function (result) {
            if(result){

                $.ajax({
                    method  : 'DELETE',
                    url     : url,
                    data    : {
                            _token  : _token
                        },
                    success: function(msg) {
                        toastr["success"](msg[1]);
                        $('#dataTable').DataTable().ajax.reload();
                    },
                    error: function( msg ) {
                        toastr["error"](msg[1]);
                        $('#dataTable').DataTable().ajax.reload();
                    }
                });

            }
        }
    });
}


// DELETE ROW FROM DATATABLE
function deleteAllChecked(url)
{
    var someObj = {};
    someObj.fruitsGranted = [];

    $("input:checkbox").each(function(){
        var $this = $(this);

        if($this.is(":checked")){
            someObj.fruitsGranted.push($this.attr("value"));
        }
    });

    var ids = someObj.fruitsGranted;

    bootbox.confirm({
        message: "هل انت متآكد لحذف هذا الصف ؟",
        buttons: {
            confirm: {
                label: 'نعم',
                className: 'btn-success'
            },
            cancel: {
                label: 'لا',
                className: 'btn-danger'
            }
        },

        callback: function (result) {
            if(result){

                $.ajax({
                    type    : "GET",
                    url     : url,
                    data    : {
                            ids     : ids,
                        },
                    success: function(msg) {

                        if (msg[0] == true){
                            toastr["success"](msg[1]);
                            $('#dataTable').DataTable().ajax.reload();
                        }
                        else{
                            toastr["error"](msg[1]);
                        }

                    },
                    error: function( msg ) {
                        toastr["error"](msg[1]);
                        $('#dataTable').DataTable().ajax.reload();
                    }
                });

            }
        }
    });
}
