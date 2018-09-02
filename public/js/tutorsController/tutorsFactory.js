/* global app, site */

app.factory('tutorsFactory', function ($http) {
    return {
        'saveRegistry': function (documentos) {
          
            return $http.post('/tutor/addcommentary', 
            documentos
            ,{
              headers: {'Content-Type': undefined }
            });
        },'detalleRegistros': function (idRegistro) {
          return $http.post('/tickets/detalleRegistros', {idRegistro: idRegistro});
        },'dateRegistry':function(){
          return $http.get('/tutor/dateregistry');
        }
    };

});
