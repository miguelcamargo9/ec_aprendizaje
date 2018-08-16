$(document).ready(function () {

  var table = $('#tickets').DataTable({
    "ajax": {
      "url": "/parents/getbyparent",
      "type": "GET"
    },
    "sAjaxDataProp": "",
    "columns": [
      {"data": "estado"},
      {"data": "estudiante"},
      {"data": "fechai"},
      {"data": "boton"}
    ],
    'order': [1, 'asc'],
    'lengthMenu': [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]]
  });
  /*
   * ENVIO A GUARDAR EL COMENTARIO QUE HIZO EL PADRE
   */
  //;
  //$("#comentario").wysihtml5();
  $("#btn-form-comentario").click(function () {
    var comentario = $("#comentario").val();
    var idCaso = $("#idCaso").val();
    var _token = $("#_token").val();
    $.ajax({
      url: "/parents/addcommentary",
      type: "POST",
      data: {
        comentario: comentario,
        id: idCaso,
        _token: _token
      }
    }).done(function () {
      $("#msg-done").show();
      window.location = "";
      //$("#comentario").attr('disabled', 'disabled');
    });
  });
});