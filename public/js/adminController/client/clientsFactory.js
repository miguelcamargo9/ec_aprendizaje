/* global app, site */

appClient.factory('clientsFactory', function ($http) {
    return {
        'editTutor': function (id, id_user, name, identification_number, email, university, degree, semester, valxhour, mobile, accountnumber) {
            return $http.post('/admin/client/edit', {id: id, id_user: id_user, name: name, identification_number: identification_number, email: email, university: university,
                degree: degree, semester: semester, valxhour: valxhour, mobile: mobile, accountnumber: accountnumber});
        },
        'createClient': function (name, lastname, identification_number, email, namesecond, lastnamesecond, identification_number_second, email_second, children) {
            return $http.post('/admin/client/create', {name: name, lastname: lastname, identification_number: identification_number, email: email, namesecond: namesecond,
                lastnamesecond: lastnamesecond, identification_number_second: identification_number_second, email_second: email_second, children: children
            });
        },
        'deleteTutor': function (id, id_user) {
            return $http.post('/admin/client/delete', {id: id, id_user: id_user});
        }
    };

});
