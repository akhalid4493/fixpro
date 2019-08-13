@extends('admin._layouts.master')
@section('title','ترتيب الخدمات')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ url(route('admin')) }}">الرئيسية</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="{{ url(route('services.index')) }}">جميع الخدمات</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">ترتيب الخدمات</a>
                </li>
            </ul>
        </div>
        <h1 class="page-title"></h1>
        <div class="row">
            <div class="profile-content">
                <div class="portlet light">
                    <div class="portlet-body">
                        <ul id="sortable" class="dd-list">
                            @foreach ($services as $service)
                              <li id="service-{{$service->id}}" class="dd-item">
                                <div class="dd-handle"> {{$service->name_ar}}</div>
                              </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-3 col-md-9">
                    <button type="button" class="btn btn-lg blue re_order">
                        ترتيب
                    </button>
                    <a href="{{url(route('services.index')) }}" class="btn btn-lg red">
                        الخلف
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>


<script type="text/javascript">
    $('.re_order').on('click', function(e) {

        var data = $('#sortable').sortable('serialize');

        $.ajax({

            url: '{{url(route('services.saveReOrder'))}}',
            type: 'GET',
            dataType: 'JSON',
            data:  data,
            contentType: false,
            cache: false,
            processData:false,
            success:function(data){
                if (data[0] == true){
                    toastr["success"](data[1]);
                }else{
                    console.log(data);
                    toastr["error"](data[1]);
                }
            },
           error: function(data){
                console.log(data);
            },
        });

    });

    $(document).ready(function () {
      $('#sortable').sortable();
    });

</script>
@stop
