/* global app, site */

app.factory('ticketsFactory', function ($http) {
  return {
    'getClients': function () {
      return $http.post('/resources/getClients');
    },
    'getTutors': function () {
      return $http.post('/resources/getTutors');
    },
    'createProcess': function (cliente, tutor, initdate, enddate,datosFactura) {
      return $http.post('/tickets/registry', {cliente: cliente, tutor: tutor, initdate: initdate, enddate: enddate,datosFactura:datosFactura});
    },
    'detalleRegistros': function (idRegistro) {
      return $http.post('/tickets/detalleRegistros', {idRegistro: idRegistro});
    },
    'aprobarRegistro': function (idRegistro,resumen,idCaso) {
      return $http.post('/tickets/aprobarRegistro', {idRegistro: idRegistro,resumen:resumen,idCaso:idCaso});
    }
  };

});
