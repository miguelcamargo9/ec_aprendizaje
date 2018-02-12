/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var app = angular.module('app', ['ngSanitize', 'ui.select'], function ($interpolateProvider) {
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
});

/**
 * AngularJS default filter with the following expression:
 * "person in people | filter: {name: $select.search, age: $select.search}"
 * performs an AND between 'name: $select.search' and 'age: $select.search'.
 * We want to perform an OR.
 */
app.filter('propsFilter', function () {
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

app.controller('ticketCtrl', ['$scope', 'ticketsFactory', '$timeout', function ($scope, ticketsFactory, $timeout) {
    ticketsFactory.getClients().success(function (data) {
      $scope.clients = data;
    });

    $scope.error = {};

    ticketsFactory.getTutors().success(function (data) {
      $scope.tutors = data;
    });

    $scope.setClient = function (client) {
      $scope.error.client = false;
      $scope.cliente = client.id;
    };

    $scope.setTutor = function (tutor) {
      $scope.error.tutor = false;
      $scope.tutor = tutor.id;
    };

    $scope.createProcess = function () {
      ticketsFactory.createProcess($scope.cliente, $scope.tutor, $scope.dateFormat($scope.initdate), $scope.dateFormat($scope.enddate)).success(function (data) {
        if (data.success) {
          $scope.success = data.msj;
          $timeout(function () {
            location.reload();
          }, 300);
        } else {
          $scope.error.msjs = data;
        }
      });
    };

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

    $scope.validate = function (action) {
      $scope.error = {};
      $scope.noerror = true;
      if (!$scope.cliente) {
        $scope.error.client = true;
        $scope.noerror = false;
      }
      if (!$scope.tutor) {
        $scope.error.tutor = true;
        $scope.noerror = false;
      }
      if (!$scope.initdate) {
        $scope.error.initdate = true;
        $scope.noerror = false;
      }
      if (!$scope.enddate) {
        $scope.error.enddate = true;
        $scope.noerror = false;
      }
      if ($scope.noerror) {
        if (action == 'add') {
          $scope.createProcess();
        }
        if (action == 'edit') {
          $scope.editProcess();
        }
      }
    };
  }]);

//CONTROLADOR PARA LOS DETALLES DE CADA REGISTRO DEL TUTOR 

app.controller('ticketInfoCtrl', ['$scope', 'ticketsFactory', function ($scope, ticketsFactory) {
    $scope.resumen="por que aca si me esta dejando";
    $scope.getDetalesRegistro=function(idRegistro,resumen){
      $scope.resumen=resumen;

      ticketsFactory.detalleRegistros(idRegistro).success(function (data) {
          $scope.horas=data;
         
      });
    };
}]);
