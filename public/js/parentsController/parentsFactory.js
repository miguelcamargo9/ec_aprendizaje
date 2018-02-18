/* global app, site */

app.factory('parentsFactory', function ($http) {
  return {
    'getClients': function () {
      return $http.post('/resources/getClients');
    },
    'getTutors': function () {
      return $http.post('/resources/getTutors');
    },
    'createProcess': function (cliente, tutor, initdate, enddate) {
      return $http.post('/tickets/registry', {cliente: cliente, tutor: tutor, initdate: initdate, enddate: enddate});
    },
    'detalleRegistros': function (idRegistro) {
      return $http.post('/tickets/detalleRegistros', {idRegistro: idRegistro});
    },
    'guardarComentario': function (idRegistro,respuestaPadre,idCaso) {
      return $http.post('/parents/addcommentary', {idRegistro: idRegistro,respuestaPadre:respuestaPadre,idCaso:idCaso});
    }
  };

});
