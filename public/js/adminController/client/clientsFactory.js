/* global app, site */

appClient.factory('clientsFactory', function ($http) {
    return {
        'editClient': function (id, id_user, id_user_two, name, lastname, identification_number, email, namesecond, lastnamesecond, identification_number_second, email_second, children) {
            return $http.post('/admin/client/edit', {id: id, id_user: id_user, id_user_two: id_user_two, name: name, lastname: lastname, identification_number: identification_number,
                email: email, namesecond: namesecond, lastnamesecond: lastnamesecond, identification_number_second: identification_number_second,
                email_second: email_second, children: children
            });
        },
        'createClient': function (name, lastname, identification_number, email, namesecond, lastnamesecond, identification_number_second, email_second, children) {
            return $http.post('/admin/client/create', {name: name, lastname: lastname, identification_number: identification_number, email: email, namesecond: namesecond,
                lastnamesecond: lastnamesecond, identification_number_second: identification_number_second, email_second: email_second, children: children
            });
        },
        'deleteClient': function (id, id_user, id_user_two) {
            return $http.post('/admin/client/delete', {id: id, id_user: id_user, id_user_two: id_user_two});
        }
    };

});
