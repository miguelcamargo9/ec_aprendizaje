/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var appTutor = angular.module('appTutor', ['ngSanitize', 'ui.select'], function ($interpolateProvider) {
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
});

/**
 * AngularJS default filter with the following expression:
 * "person in people | filter: {name: $select.search, age: $select.search}"
 * performs an AND between 'name: $select.search' and 'age: $select.search'.
 * We want to perform an OR.
 */
appTutor.filter('propsFilter', function () {
  return function (items, props) {
    var out = [];

    if (angular.isArray(items)) {
      var keys = Object.keys(props);

      items.forEach(function (item) {
        var itemMatches = false;

        for (var i = 0; i < keys.length; i++) {
          var prop = keys[i];
          var text = props[prop].toLowerCase();
          if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
            itemMatches = true;
            break;
          }
        }

        if (itemMatches) {
          out.push(item);
        }
      });
    } else {
      // Let the output be the input untouched
      out = items;
    }

    return out;
  };
});

appTutor.controller('tutorsCtrl', ['$scope', 'tutorsFactory', '$timeout', '$window', '$filter', function ($scope, tutorsFactory, $timeout, $window, $filter) {
    $scope.university = {};
    $scope.degree = {};
    $scope.bank = {};
    $scope.accounttype = {};

    tutorsFactory.getUniversities().success(function (data) {
      $scope.universities = data;
      if ($scope.iduniversity) {
        $scope.university.selected = $filter('filter')($scope.universities, {id: $scope.iduniversity}, true)[0];
      }
    });

    tutorsFactory.getDegrees().success(function (data) {
      $scope.degrees = data;
      if ($scope.iddegree) {
        $scope.degree.selected = $filter('filter')($scope.degrees, {id: $scope.iddegree}, true)[0];
      }
    });

    tutorsFactory.getBanks().success(function (data) {
      $scope.banks = data;
      if ($scope.idaccounttype) {
        $scope.accounttype.selected = $filter('filter')($scope.accounttypes, {name: $scope.idaccounttype}, true)[0];
      }
      if ($scope.idbank) {
        $scope.bank.selected = $filter('filter')($scope.banks, {id: $scope.idbank}, true)[0];
      }
    });

    $scope.accounttypes = [
      {id: '1', name: 'Corriente'},
      {id: '2', name: 'Ahorros'}
    ];

    $scope.error = {};

    $scope.dateFormat = function (date) {
      var year = date.getFullYear();
      var month = date.getMonth() + 1;
      var dt = date.getDate();

      if (dt < 10) {
        dt = '0' + dt;
      }
      if (month < 10) {
        month = '0' + month;
      }

      return year + '-' + month + '-' + dt;
    };

    $scope.setUniversity = function (university) {
      $scope.error.university = false;
      $scope.viewnewuni = false;
      $scope.university.selected = university;
      $scope.iduniversity = university.id;
    };

    $scope.setDegree = function (degree) {
      $scope.error.degree = false;
      $scope.viewnewdeg = false;
      $scope.degree.selected = degree;
      $scope.iddegree = degree.id;
    };

    $scope.setAccountType = function (accounttype) {
      $scope.error.accounttype = false;
      $scope.accounttype.selected = accounttype;
      $scope.idaccounttype = accounttype.name;
    };

    $scope.setBank = function (bank) {
      $scope.error.bank = false;
      $scope.bank.selected = bank;
      $scope.idbank = bank.id;
    };

    $scope.createTutor = function () {
      $scope.newuniversity = (!$scope.newuniversity) ? "" : $scope.newuniversity;
      $scope.newdegree = (!$scope.newdegree) ? "" : $scope.newdegree;
      $scope.semester = ($scope.graduate) ? 0 : $scope.semester;
      $scope.graduate = ($scope.graduate) ? true : false;
      $scope.pastregister = ($scope.pastregister) ? 'SI' : 'NO';

      tutorsFactory.createTutor($scope.name, $scope.lastname, $scope.identification_number, $scope.email, $scope.iduniversity, $scope.newuniversity,
              $scope.iddegree, $scope.newdegree, $scope.semester, $scope.graduate, $scope.mobile, $scope.pastregister, $scope.accountnumber,
              $scope.idaccounttype, $scope.idbank).success(function (data) {
        if (data.success) {
          $scope.success = data.msj;
          $timeout(function () {
            $window.location.href = '/admin/tutors/list';
          }, 2000);
        } else {
          $scope.error.msjs = data;
        }
      });
    };

    $scope.editTutor = function () {
      $scope.newuniversity = (!$scope.newuniversity) ? "" : $scope.newuniversity;
      $scope.newdegree = (!$scope.newdegree) ? "" : $scope.newdegree;
      $scope.semester = ($scope.graduate) ? 0 : $scope.semester;
      $scope.graduate = ($scope.graduate) ? true : false;
      $scope.pastregister = ($scope.pastregister) ? 'SI' : 'NO';
      
      tutorsFactory.editTutor($scope.idtutor, $scope.iduser, $scope.name, $scope.identification_number, $scope.email, $scope.iduniversity, $scope.newuniversity,
              $scope.iddegree, $scope.newdegree, $scope.semester, $scope.graduate, $scope.mobile, $scope.pastregister, $scope.accountnumber,
              $scope.idaccounttype, $scope.idbank).success(function (data) {
        if (data.success) {
          $scope.success = data.msj;
          $timeout(function () {
            $window.location.href = '/admin/tutors/list';
          }, 2000);
        } else {
          $scope.error.msjs = data;
        }
      });
    };

    $scope.deleteTutor = function () {
      tutorsFactory.deleteTutor($scope.idtutor, $scope.iduser).success(function (data) {
        if (data.success) {
          $scope.success = data.msj;
          $timeout(function () {
            $window.location.href = '/admin/tutors/list';
          }, 2000);
        } else {
          $scope.error.msjs = data;
        }
      });
    };
    
    $scope.activateTutor = function () {
      tutorsFactory.activateTutor($scope.idtutor, $scope.iduser).success(function (data) {
        if (data.success) {
          $scope.success = data.msj;
          $timeout(function () {
            $window.location.href = '/admin/tutors/list';
          }, 2000);
        } else {
          $scope.error.msjs = data;
        }
      });
    };
    
    $scope.inactivateTutor = function () {
      tutorsFactory.inactivateTutor($scope.idtutor, $scope.iduser).success(function (data) {
        if (data.success) {
          $scope.success = data.msj;
          $timeout(function () {
            $window.location.href = '/admin/tutors/list';
          }, 2000);
        } else {
          $scope.error.msjs = data;
        }
      });
    };

    $scope.validate = function (action) {
      $scope.error = {};
      $scope.noerror = true;
      if (!$scope.name) {
        $scope.error.name = true;
        $scope.noerror = false;
      }
      if (action === 'add') {
        if (!$scope.lastname) {
          $scope.error.lastname = true;
          $scope.noerror = false;
        }
      }
      if (!$scope.identification_number) {
        $scope.error.identification_number = true;
        $scope.noerror = false;
      }
      if (!$scope.email) {
        $scope.error.email = true;
        $scope.noerror = false;
      }
      if (!$scope.university.selected && !$scope.newuniversity) {
        $scope.error.university = true;
        $scope.noerror = false;
      }
      if (!$scope.degree.selected && !$scope.newdegree) {
        $scope.error.degree = true;
        $scope.noerror = false;
      }
      if (!$scope.graduate && !$scope.semester) {
        $scope.error.semester = true;
        $scope.noerror = false;
      }
      if (!$scope.mobile) {
        $scope.error.mobile = true;
        $scope.noerror = false;
      }
      if (!$scope.accountnumber) {
        $scope.error.accountnumber = true;
        $scope.noerror = false;
      }
      if (!$scope.accounttype.selected) {
        $scope.error.accounttype = true;
        $scope.noerror = false;
      }
      if (!$scope.bank.selected) {
        $scope.error.bank = true;
        $scope.noerror = false;
      }
      if ($scope.noerror) {
        if (action === 'add') {
          $scope.createTutor();
        }
        if (action === 'edit') {
          $scope.editTutor();
        }
      }
    };
  }]);


