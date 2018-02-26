$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('#clients').DataTable({
        "ajax": {
            "url": "/admin/client/getall",
            "type": "POST"
        },
        "sAjaxDataProp": "",
        'columnDefs': [{
                'targets': 0,
                'className': 'dt-body-center'
            }],
        "columns": [
            {"data": "user.name"},
            {"data": "user.identification_number"},
            {"data": "user.email"},
            {"data": "opciones"}
        ],
        'order': [0, 'asc'],
        "language": {
            "zeroRecords": "NO EXISTEN TUTORES."
        },
        dom: '<B><"row"><lftip>',
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'EXCEL',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, 1, 2, 3]
                }
            }, {
                extend: 'csvHtml5',
                text: ' CSV',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, 1, 2, 3]
                }
            }, {
                extend: 'pdfHtml5',
                text: 'PDF',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, 1, 2, 3]
                }
            }, {
                extend: 'copyHtml5',
                text: 'COPY',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, 1, 2, 3]
                }
            }
        ]
    });
});
