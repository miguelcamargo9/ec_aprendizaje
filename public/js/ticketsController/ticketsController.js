/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var app = angular.module('app', ['ui.bootstrap', 'ngSanitize', 'ui.select', 'summernote'], function ($interpolateProvider) {
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

    $scope.factura = {
      nombre: "",
      direccion: "",
      nit: "",
      telefono: "",
      ciudad: ""
    };//GUARDO LOS DATOS DE FACTURACION

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
      if (!$scope.enddate) {
        $scope.enddate = new Date(100000000000);
      }
      console.log($scope.factura);
      ticketsFactory.createProcess($scope.cliente, $scope.tutor, $scope.dateFormat($scope.initdate), $scope.dateFormat($scope.enddate), $scope.factura
              ).success(function (data) {
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

      //RECORRO LOS DATOS DE LA FACTURA PARA VERIFICAR QUE NO ESTE VACIOS
      angular.forEach($scope.factura, function (value, key) {

        //EXCLUYO LOS CAMPOS QUE NO QUIERO VERIFICAR
        if (key !== "telefono" && key !== "email") {
          if (value === "") {
            $scope.error[key] = true;
            $scope.noerror = false;
          }
        }
      });
      if ($scope.noerror) {

        switch (action) {
          case"add":
            $scope.createProcess();
            break;
          case"edit":
            $scope.editProcess();
            break;
          default :
            console.log("Accion no encontrada");
        }
      }
    };
    ///CONFIGURACION PARA EL CALENDARIO DE SELECCIONAR LA FECHA

    //////FORMATOS DE LA FECHA
    $scope.formats = ['yyyy-MM-dd', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];
    $scope.altInputFormats = ['M!/d!/yyyy'];
    /////ABRIR EL CALENDARIO

    $scope.dateOptions = {
//      dateDisabled: disabled,
      formatYear: 'yy',
      startingDay: 1
    };

    $scope.today = function () {
      $scope.dt = new Date();
    };
    
    $scope.today();

    $scope.clear = function () {
      $scope.dt = null;
    };

    // Disable weekend selection
//    function disabled(data) {
//      var date = data.date,
//              mode = data.mode;
//      return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
//    }

    $scope.openinitdate = function () {
      $scope.popupinitdate.opened = true;
    };
    
    $scope.openenddate = function () {
      $scope.popupenddate.opened = true;
    };

    $scope.popupinitdate = {
      opened: false
    };

    $scope.popupenddate = {
      opened: false
    };
  }]);

//CONTROLADOR PARA LOS DETALLES DE CADA REGISTRO DEL TUTOR 

app.controller('ticketInfoCtrl', ['$scope', 'ticketsFactory', '$timeout', function ($scope, ticketsFactory, $timeout) {

    //TRAER LOS DETALLES DE LAS HORAS DEL REGISTRO SELECCIONADO
    $scope.getDetalesRegistro = function (idRegistro, resumen, totalHoras, estado, comPadre) {
      $scope.resumen = resumen;
      $scope.idRegistro = idRegistro;
      $scope.totalH = totalHoras;
      $scope.comPadre = comPadre;
      $scope.answered = (estado === 's') ? true : false;
      $scope.answeredP = (comPadre != '') ? false : true;

      ticketsFactory.detalleRegistros(idRegistro).then(function (respuesta) {
        $scope.horas = respuesta.data;
      });
    };

    //GUARDAR Y APROBAR LOS CAMBIOS EL EN COMNETARIO DEL TUTOR
    $scope.aprobarRegistro = function () {
      var idRegistro = $scope.idRegistro;
      var resumen = $scope.resumen;
      var idCaso = $scope.idCaso;
      ticketsFactory.aprobarRegistro(idRegistro, resumen, idCaso).then(function (respuesta) {
        rta = respuesta.data;
        if (rta.success) {
          $scope.success = rta.msj;
          $timeout(function () {
            location.reload();
          }, 3000);
        } else {
          $scope.error.msjs = rta;
        }
      });
    };
  }]);
