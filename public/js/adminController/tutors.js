$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('#tutors').DataTable({
        "ajax": {
            "url": "/admin/tutors/getall",
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
            {"data": "celular"},
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
                    columns: [0, 1, 2]
                }
            }, {
                extend: 'csvHtml5',
                text: ' CSV',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, 1, 2]
                }
            }, {
                extend: 'pdfHtml5',
                text: 'PDF',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, 1, 2]
                }
            }, {
                extend: 'copyHtml5',
                text: 'COPY',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: [0, 1, 2]
                }
            }
        ]
    });

    $("#editar").click(function () {
        var comentario = $("#comentario_tutor").val();
        var fecha_ini = $("#fecha_ini").val();
        var fecha_fin = $("#fecha_fin").val();
        var idCaso = $("#idCaso").val();
        var _token = $("#_token").val();
        $.ajax({
            url: "/tickets/edit",
            type: "POST",
            data: {
                comentario: comentario,
                fecha_ini: fecha_ini,
                fecha_fin: fecha_fin,
                id: idCaso,
                _token: _token
            }
        }).done(function () {
            $("#msg-done").show();
        });
    });

    $("#completar").click(function () {
        var comentario = $("#comentario_tutor").val();
        var fecha_ini = $("#fecha_ini").val();
        var fecha_fin = $("#fecha_fin").val();
        var idCaso = $("#idCaso").val();
        var _token = $("#_token").val();
        $.ajax({
            url: "/tickets/edit",
            type: "POST",
            data: {
                comentario: comentario,
                cierre: true,
                fecha_ini: fecha_ini,
                fecha_fin: fecha_fin,
                id: idCaso,
                _token: _token
            }
        }).done(function () {
            $("#msg-done").show();
        });
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
