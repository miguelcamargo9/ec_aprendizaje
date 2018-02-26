var app = angular.module('app', ['ui.bootstrap', 'summernote'], function ($interpolateProvider) {
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
});

app.controller("registrosHoras", ['$scope', 'tutorsFactory','$timeout', function ($scope, tutorsFactory,$timeout) {


    $scope.choices = [{
        hI: new Date("8/24/2009 12:00:00:000"),
        hF: new Date("8/24/2009 12:00:00:000")
      }];



    $scope.formats = ['yyyy-MM-dd', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
    $scope.format = $scope.formats[0];
    $scope.altInputFormats = ['M!/d!/yyyy'];

    //ABRIR EL CALENDARIO
    $scope.opened = [];
    $scope.open = function ($event, index) {
      $event.preventDefault();
      $event.stopPropagation();
      $scope.opened[index] = true;
    };



    $scope.addNewChoice = function () {
      $scope.choices.push({
        hI: new Date("8/24/2009 12:00:00:000"),
        hF: new Date("8/24/2009 12:00:00:000")
      });


    };

    $scope.removeNewChoice = function () {
      var newItemNo = $scope.choices.length - 1;
      if (newItemNo !== 0) {
        $scope.choices.pop();
        calcHTotal();
      }
    };

    $scope.showAddChoice = function (choice) {
      return choice.id === $scope.choices[$scope.choices.length - 1].id;
    };
    var totalhoras = 0;
    var calcHTotal = function () {
      var registros = $scope.choices;
      var horas = 0;
      for (reg in registros) {
        var hi = registros[reg].hI;
        var hf = registros[reg].hF;
        if (hi < hf) {

          totalhoras = ((hf - hi) / 1000);
          horas += (totalhoras / 3600);
        }
      }
      // totalhoras++;
      $scope.choices.totalHoras = horas;
    };
    $scope.changed = function () {
      calcHTotal();
    };
    
    $scope.choices.mensaje = "";
    $scope.saveRegistry = function () {
      var totalHoras = $scope.choices.totalHoras;
      var msg = $scope.choices.mensaje;
      var id = $scope.idCaso;
      console.log($scope.choices);
      tutorsFactory.saveRegistry($scope.choices, totalHoras, msg, id).then(function (respuesta) {
       rta= respuesta.data;
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
    
     //TRAER LOS DETALLES DE LAS HORAS DEL REGISTRO SELECCIONADO
    $scope.getDetalesRegistro = function (idRegistro, resumen,totalHoras) {
      $scope.resumen = resumen;
      $scope.idRegistro = idRegistro;
      $scope.totalH = totalHoras;
      tutorsFactory.detalleRegistros(idRegistro).then(function (respuesta) {
        $scope.horas = respuesta.data;
      });
    };

  }]);

