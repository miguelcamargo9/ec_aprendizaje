/* global app, site */

app.factory('ticketsFactory', function ($http) {
    return {
        'getClients': function () {
            return $http.post('/resources/getClients');
        },
        'editDevice': function (name, ipaddress, keyradius, makerID, typeID, pop, utility, reference, sequent, deviceId, nameOLD, ipOLD) {
            return $http.post('/editarequipo', {name: name, ip: ipaddress, numinvent: keyradius, fabricante: makerID, 
                                                tipo: typeID, pop: pop, utility : utility, reference: reference, sequent: sequent, 
                                                id: deviceId, name_old: nameOLD, ip_old: ipOLD, editado: 'editado'});
        },
    };

});
