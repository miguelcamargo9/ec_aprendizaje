/* global app, site */

appTutor.factory('tutorsFactory', function ($http) {
  return {
    'editTutor': function (id, id_user, name, identification_number, email, university, newuniversity, degree, newdegree, semester, graduate, mobile,
            pastregister, accountnumber, accounttype, bank) {
      return $http.post('/admin/tutor/edit', {id: id, id_user: id_user, name: name, identification_number: identification_number, email: email, university: university,
        newuniversity: newuniversity, degree: degree, newdegree: newdegree, semester: semester, graduate: graduate, mobile: mobile, pastregister: pastregister,
        accountnumber: accountnumber, accounttype: accounttype, bank: bank});
    },
    'createTutor': function (name, lastname, identification_number, email, university, newuniversity, degree, newdegree, semester, graduate, mobile,
            pastregister, accountnumber, accounttype, bank) {
      return $http.post('/admin/tutor/create', {name: name, lastname: lastname, identification_number: identification_number, email: email, university: university,
        newuniversity: newuniversity, degree: degree, newdegree: newdegree, semester: semester, graduate: graduate, mobile: mobile, pastregister: pastregister,
        accountnumber: accountnumber, accounttype: accounttype, bank: bank});
    },
    'deleteTutor': function (id, id_user) {
      return $http.post('/admin/tutor/delete', {id: id, id_user: id_user});
    },
    'activateTutor': function (id, id_user) {
      return $http.post('/admin/tutor/activate', {id: id, id_user: id_user});
    },
    'inactivateTutor': function (id, id_user) {
      return $http.post('/admin/tutor/inactivate', {id: id, id_user: id_user});
    },
    'getUniversities': function () {
      return $http.post('/resources/getUniversities');
    },
    'getDegrees': function () {
      return $http.post('/resources/getDegrees');
    },
    'getBanks': function () {
      return $http.post('/resources/getBanks');
    }
  };

});
