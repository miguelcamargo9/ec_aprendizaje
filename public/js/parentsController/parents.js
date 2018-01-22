$(document).ready(function () {
  
    var table = $('#tickets').DataTable({
        "ajax": {
            "url": "/parents/getbyparent",
            "type": "GET"
        },
        "sAjaxDataProp": "",
//        'columnDefs': [{
//            'targets': 0,
//            'searchable': false,
//            'orderable': false,
//            'className': 'dt-body-center',
//            'render': function (data, type, full, meta) {
//                return '<input type="checkbox" name="id[]" value="'
//                    + $('<div/>').text(data).html() + '">';
//            }
//        }],
        "columns": [
            //{"data": "id"},
            {"data": "estado"},
            {"data": "estudiante"},
            {"data": "tutor"},
            {"data": "fechai"},
            {"data": "fechaf"},
            {"data": "boton"}
        ],
        'order': [1, 'asc']
    });

    // Handle click on "Select all" control
    $('#example-select-all').on('click', function () {
        // Check/uncheck all checkboxes in the table
        var rows = table.rows({'search': 'applied'}).nodes();
        $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

    // Handle click on checkbox to set state of "Select all" control
    $('#tickets tbody').on('change', 'input[type="checkbox"]', function () {
        // If checkbox is not checked
        if (!this.checked) {
            var el = $('#example-select-all').get(0);
            // If "Select all" control is checked and has 'indeterminate' property
            if (el && el.checked && ('indeterminate' in el)) {
                // Set visual state of "Select all" control
                // as 'indeterminate'
                el.indeterminate = true;
            }
        }
    });

    $('#frm-example').on('submit', function (e) {
        var form = this;

        // Iterate over all checkboxes in the table
        table.$('input[type="checkbox"]').each(function () {
            // If checkbox doesn't exist in DOM
            if (!$.contains(document, this)) {
                // If checkbox is checked
                if (this.checked) {
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', this.name)
                            .val(this.value)
                    );
                }
            }
        });

        // FOR TESTING ONLY

        // Output form data to a console
        $('#example-console').text($(form).serialize());
        var data = {};
        data.ids = table.$('input[type="checkbox"]').serialize();
        console.log("Form submission", $(form).serialize());
        $.post({
            url: '/tickets/updatestate',
            data: data
        })
            .done(function (data) {
                alert(data);
                window.location.reload();
            })
            .fail(function () {
                alert("error");
            });

        // Prevent actual form submission
        e.preventDefault();
    });
});


// $(document).ready(function () {
//     $('#loading').show();
//     $('#tickets').dataTable({
//         columnDefs: [ {
//             orderable: false,
//             className: 'select-checkbox',
//             targets:   0
//         } ],
//         select: {
//             style:    'os',
//             selector: 'td:first-child'
//         },
//         "ajax": {
//             "url": "/tickets/getall",
//             "type": "POST"
//         },
//         "sAjaxDataProp": "",
//         "columns": [
//             {"data": "id_cliente"},
//             {"data": "id_tutor"},
//             {"data": "fecha_inicio"},
//             {"data": "fecha_fin"},
//             {"data": "descripcion"},
//             {"data": "Opciones"}
//         ],
//         "language": {
//             "zeroRecords": "NO EXISTEN CASOS."
//         },
//         dom: '<B><"row"><lftip>',
//         buttons: [
//             {
//                 extend: 'excelHtml5',
//                 text: 'EXCEL',
//                 exportOptions: {
//                     modifier: {
//                         page: 'current'
//                     },
//                     columns: [0, 1, 2]
//                 }
//             },{
//                 extend: 'csvHtml5',
//                 text: ' CSV',
//                 exportOptions: {
//                     modifier: {
//                         page: 'current'
//                     },
//                     columns: [0, 1, 2]
//                 }
//             },{
//                 extend: 'pdfHtml5',
//                 text: 'PDF',
//                 exportOptions: {
//                     modifier: {
//                         page: 'current'
//                     },
//                     columns: [0, 1, 2]
//                 }
//             },{
//                 extend: 'copyHtml5',
//                 text: 'COPY',
//                 exportOptions: {
//                     modifier: {
//                         page: 'current'
//                     },
//                     columns: [0, 1, 2]
//                 }
//             }
//         ],
//         "lengthMenu":
//                 [[10, 25, 50, 100, 200, 500, -1], [10, 25, 50, 100, 200, 500, "All"]]
//     });
//     $(document).ajaxComplete(function () {
//         $("#loading").hide();
//         var objetoDataTable = $("#tickets").dataTable();
//         $(".ticketassign", objetoDataTable.fnGetNodes()).bind('click', function (e) {
//             var customerid = $(this).attr('alt');
//             $('#customerid').val(customerid);
//             $('#state').val("1");
//             e.stopPropagation();
//             //$('#comentario').show();
//         });
//         $(".ticketassigned", objetoDataTable.fnGetNodes()).confirm({
//             text: "Realmente quiere asignar el ticket?",
//             title: "Confirmación Requerida",
//             confirm: function (button) {
//                 var customerid = $(".ticketassigned").attr('alt');
//                 $('#customerid').val(customerid);
//                 $('#state').val("0");
//                 //$("#commentform").submit();
//             },
//             cancel: function (button) {
//                 // nothing to do
//             },
//             confirmButton: "Confirmar",
//             cancelButton: "Cancelar",
//             confirmButtonClass: "btn-success",
//             cancelButtonClass: "btn-default",
//             dialogClass: "modal-dialog modal-lg"
//         });
//
//         $("body").click(function () {
//             $("#comentario:visible").hide();
//         });
//         $("#comentario").bind('click', function (e) {
//             e.stopPropagation();
//         });
//     });
// });
