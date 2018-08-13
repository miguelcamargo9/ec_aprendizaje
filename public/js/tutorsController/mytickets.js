$(document).ready(function () {
  var table = $('#tickets').DataTable({
    "ajax": {
      "url": "/tutor/getassigned",
      "type": "POST"
    },
    "sAjaxDataProp": "",
    "columns": [
      {"data": "id_estado"},
      {"data": "id_cliente"},
      {"data": "fecha_inicio"},
      {"data": "ver"}
    ],
    "language": {
      "zeroRecords": "No tiene procesos asignados."
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
    ],
    'order': [1, 'asc'],
    'lengthMenu': [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]]
  });
});
