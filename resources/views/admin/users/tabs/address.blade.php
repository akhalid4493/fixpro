@include('admin.users.tabs.models.addAddress')

<div class="tab-pane" id="address">
    <div class="table-toolbar">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group">
                    <button type="button" class="btn sbold green" data-toggle="modal" data-target="#myModal">
                        <i class="fa fa-plus"></i> اضافة
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- DataTable --}}
    <table class="table table-striped table-bordered table-hover" id="dataTable">
        <thead>
            <tr>
                <th width="2%" class="chkParent">
                    <a href="#.">تحديد الكل</a>
                </th>
                <th width="2%">#</th>
                <th>المنطقة</th>
                <th>العنوان</th>
                <th>القطعة</th>
                <th>الشارع</th>
                <th>المنزل</th>
                <th>الدور</th>
                <th>رقم الشقة</th>
                <th>الحالة</th>
                <th>خيارات</th>
            </tr>
        </thead>
    </table>
    <div class="row">
        @permission('delete_addresses')
        <div class="col-md-2">
            <div class="form-group">
                <select name="xx" class="form-control">
                    <option value="delete">
                        حذف المحدد
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" id="deleteChecked" class="btn red btn-sm" onclick="deleteAllChecked('{{ url(route('addresses.deletes')) }}')">
            تطبيق
            </button>
        </div>
        @endpermission
    </div>
</div>


@section('addressDT')

<script> 
 function tableGenerate(data='') {

    var dataTable =
    $('#dataTable').DataTable({
        "ajax" : {
            url:"{{ route('addresses.dataTable','user_id='.$user->id) }}",
            type:"GET",
            data : { 
                req : data, 
            },
        },
        "processing":true,
        "serverSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Arabic.json"
        },
        "order": [[ 1 , "desc" ]],
        "columns":[
            { "data": "listBox"   , "orderable": false  },
            { "data": "id"    },
            { "data": "province_id" },
            { "data": "address"     },
            { "data": "block"       },
            { "data": "street"      },
            { "data": "building"    },
            { "data": "floor"       },
            { "data": "house_no"    },
            { "data": "status"      },
            { "data": "options"   , "orderable": false },
        ],
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50 , 100 , 500],
            [ '10 rows', '25 rows', '50 rows', '100 rows' , '500 rows']
        ],
        buttons: [
        'pageLength',
        'colvis',{
                extend: 'csv',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
            extend: 'print',
            exportOptions: {
                stripHtml: true,
                columns: ':visible'
                }
            },
        ]
    });
    
}
</script>

@stop