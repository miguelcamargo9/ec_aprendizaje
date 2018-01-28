/* global app, site */

app.factory('ticketsFactory', function ($http) {
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
    };

});
