/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var app = angular.module('app',['ngSanitize'], function ($interpolateProvider) {
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
});


//CONTROLADOR PARA LOS DETALLES DE CADA REGISTRO DEL TUTOR 

app.controller('ticketInfoCtrl', ['$scope', 'parentsFactory', '$timeout', function ($scope, parentsFactory,$timeout) {

    //TRAER LOS DETALLES DE LAS HORAS DEL REGISTRO SELECCIONADO
    $scope.getDetalesRegistro = function (idRegistro, resumen,totalHoras,respuestaPadre) {
      $scope.resumen = resumen;
      $scope.idRegistro = idRegistro;
      $scope.totalH = totalHoras;
      $scope.respuestaPadre = respuestaPadre;
      if(respuestaPadre!==""){
        $scope.answered=true;
      }
      parentsFactory.detalleRegistros(idRegistro).then(function (respuesta) {
        $scope.horas = respuesta.data;
      });
    };

    //GUARDAR Y APROBAR LOS CAMBIOS EL EN COMNETARIO DEL TUTOR
    $scope.guardarComentario = function () {
      var idRegistro = $scope.idRegistro;
      var respuestaPadre = $scope.respuestaPadre;
      var idCaso = $scope.idCaso;
      parentsFactory.guardarComentario(idRegistro,respuestaPadre,idCaso).then(function (respuesta) {
        //$scope.horas = respuesta.data;
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
  }]);
