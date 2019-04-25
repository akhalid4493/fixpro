<div class="tab-pane" id="previews">
    {{-- DataTable --}}
    <table class="table table-striped table-bordered table-hover dataTable2" id="dataTable2">
        <thead>
            <tr>
                <th width="2%">#</th>
                <th>اسم العميل</th>
                <th>البريد</th>
                <th>رقم الهاتف</th>
                <th>تاريخ طلب المعاينة</th>
                <th>الحالة</th>
                <th>ملاحظات</th>
                <th>تاريخ الانشاء</th>
                <th>العمليات</th>
            </tr>
        </thead>
    </table>
    <div class="row"></div>
</div>


@section('PreviewDT')

<script> 
var dataTable =
    $('#dataTable2').DataTable({
        "ajax": "{{ route('previews.dataTable','user_id='.$user->id) }}",
        "processing":true,
        "serverSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Arabic.json"
        },
        "order": [[ 0 , "desc" ]],
        "columns":[
            { "data": "id"    },
            { "data": "full_name" , "orderable": false},
            { "data": "email" , "orderable": false},
            { "data": "mobile" , "orderable": false},
            { "data": "time" ,"width": "140px"},
            { "data": "preview_status_id" },
            { "data": "note" },
            { "data": "created_at" },
            { "data": "options"  , "orderable": false ,"width": "10%"},
        ],
        dom: 'Bfrtip',
        lengthMenu: [
            [ 10, 25, 50 , 100 , 500 ],
            [ '10 rows', '25 rows', '50 rows', '100 rows' , '500 rows']
        ],
        buttons: [
            'pageLength',
            'colvis',
            {
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
</script>

@stop