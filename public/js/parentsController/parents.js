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
  /*
   * ENVIO A GUARDAR EL COMENTARIO QUE HIZO EL PADRE
   */
  console.log(666);
  $("#btn-form-comentario").click(function () {
    console.log(666);
    var comentario = $("#comentario").val();
    var idCaso = $("#idCaso").val();
    var _token = $("#_token").val();
    $.ajax({
      url:"/parents/addcommentary",
      type:"POST",
      data:{
        comentario:comentario,
        id:idCaso,
        _token:_token
      }
    }).done(function () {
      $("#msg-done").show();
    });
  });
});