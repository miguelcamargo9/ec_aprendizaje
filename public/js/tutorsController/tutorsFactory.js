/* global app, site */

app.factory('tutorsFactory', function ($http) {
    return {
        'saveRegistry': function (registros,totalH,msg,id) {
            return $http.post('/tutor/addcommentary', {
              registros: registros,
              totalH:totalH,
              msg:msg,
              idCaso:id
            });
        },'detalleRegistros': function (idRegistro) {
          return $http.post('/tickets/detalleRegistros', {idRegistro: idRegistro});
        },'dateRegistry':function(){
          return $http.get('/tutor/dateregistry');
        }
    };

});
