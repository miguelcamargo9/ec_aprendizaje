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