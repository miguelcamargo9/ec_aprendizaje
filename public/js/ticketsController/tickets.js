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

  ///ELIMINAR EL CASO
  $("#tickets").on('click','.eliminar-caso',function () {
    var eliminar = confirm("Desea eliminar el caso");
    var _this = $(this);
    var idCaso = _this.data("id");
    var _token = $("#_token").val();
    console.log(_token)
    if (eliminar) {
      $.ajax({
        url: "/tickets/eliminar",
        type: "POST",
        data: {
          idCaso: idCaso,
          _token: _token
        }
      }).done(function (rta) {
        $("#msj").text(rta.msj);
        $("#msg-done").show();
        setTimeout(function(){ location.reload(); }, 3000);
      });
    }
  });

});