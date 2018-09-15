$(document).ready(function () {
  var table = $('#tickets').DataTable({
    "ajax": {
      "url": "/tickets/getall",
      "type": "POST"
    },
    "sAjaxDataProp": "",
    "columns": [
      {"data": "id_estado"},
      {"data": "id_cliente"},
      {"data": "fecha_inicio"},
      {"data": "ver"}
    ],
    'order': [1, 'asc'],
    'lengthMenu': [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]]
  });

  $("#editar").click(function () {
    var comentario = $("#comentario_tutor").val();
    var fecha_ini = $("#fecha_ini").val();
    var idCaso = $("#idCaso").val();
    var _token = $("#_token").val();
    $.ajax({
      url: "/tickets/edit",
      type: "POST",
      data: {
        comentario: comentario,
        fecha_ini: fecha_ini,
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
    var idCaso = $("#idCaso").val();
    var _token = $("#_token").val();
    $.ajax({
      url: "/tickets/edit",
      type: "POST",
      data: {
        comentario: comentario,
        cierre: true,
        fecha_ini: fecha_ini,
        id: idCaso,
        _token: _token
      }
    }).done(function () {
      $("#msg-done").show();
    });
  });
});