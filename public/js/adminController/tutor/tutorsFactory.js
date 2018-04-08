/* global app, site */

appTutor.factory('tutorsFactory', function ($http) {
  return {
    'editTutor': function (id, id_user, name, identification_number, email, university, degree, semester, valxhour, mobile, accountnumber) {
      return $http.post('/admin/tutor/edit', {id: id, id_user: id_user, name: name, identification_number: identification_number, email: email, university: university,
        degree: degree, semester: semester, valxhour: valxhour, mobile: mobile, accountnumber: accountnumber});
    },
    'createTutor': function (name, lastname, identification_number, email, university, degree, semester, valxhour, mobile, accountnumber) {
      return $http.post('/admin/tutor/create', {name: name, lastname: lastname, identification_number: identification_number, email: email, university: university,
        degree: degree, semester: semester, valxhour: valxhour, mobile: mobile, accountnumber: accountnumber
      });
    },
    'deleteTutor': function (id, id_user) {
      return $http.post('/admin/tutor/delete', {id: id, id_user: id_user});
    },
    'getUniversities': function () {
      return $http.post('/resources/getUniversities');
    }
  };

});
