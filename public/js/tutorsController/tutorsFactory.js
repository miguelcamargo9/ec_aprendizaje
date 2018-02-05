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
        }
    };

});
