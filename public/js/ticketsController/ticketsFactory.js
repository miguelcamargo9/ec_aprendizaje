/* global app, site */

app.factory('ticketsFactory', function ($http) {
  return {
    'getClients': function () {
      return $http.post('/resources/getClients');
    },
    'getTutors': function () {
      return $http.post('/resources/getTutors');
    },
    'getTutorById': function (idTutor) {
      return $http.post('/resources/getTutorById', {idTutor: idTutor});
    },
    'createProcess': function (cliente, tutors, initdate, datosFactura) {
      return $http.post('/tickets/registry', {cliente: cliente, tutors: tutors, initdate: initdate, datosFactura: datosFactura});
    },
    'editProcess': function (id, tutors, datosFactura) {
      return $http.post('/tickets/editTicket', {id: id, tutors: tutors, datosFactura: datosFactura});
    },
    'detalleRegistros': function (idRegistro) {
      return $http.post('/tickets/detalleRegistros', {idRegistro: idRegistro});
    },
    'aprobarRegistro': function (idRegistro, resumen, idCaso) {
      return $http.post('/tickets/aprobarRegistro', {idRegistro: idRegistro, resumen: resumen, idCaso: idCaso});
    }
  };

});
