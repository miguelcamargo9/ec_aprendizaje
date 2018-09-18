var app = angular.module('app', ['ui.bootstrap', 'summernote'], function ($interpolateProvider) {
  $interpolateProvider.startSymbol('<%');
  $interpolateProvider.endSymbol('%>');
});

app.controller("registrosHoras", ['$scope', 'tutorsFactory', '$timeout', function ($scope, tutorsFactory, $timeout) {

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
      $timeout(function () {
        $scope.opened[index] = true;
      });
    };

    //VALIDAR SI PUEDE SELECCIONAR LA FECHA
    $scope.dateOptions = {
      startingDay: 1
    };
    $scope.validaFecha = function (_this, fecha) {
      //TRAIGO LAS FECHAS VALIDAD PARA SELECCIONAR EN EL REGISTO
      tutorsFactory.dateRegistry().then(function (datos) {
        var fechas = datos.data;
        var permiso = fechas.permiso;
        var index = (_this.$index);
        if (permiso === "NO") {
          var fechaIni = new Date(fechas.fechaIni);
          var fechaFin = new Date(fechas.fechaFin);

          if (fecha.getTime() < fechaIni.getTime()) {
            alert("No puedes seleccionar fechas de una semana anterior \n Por facor comunicate con el administrador.");
            $scope.choices[index]['fecha'] = null;
          }

          if (fecha.getTime() > fechaFin.getTime()) {
            alert("No puedes seleccionar fechas superiores a esta semana");
          }

        }
      });
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
      angular.forEach($scope.choices, function(value, key) {
        $scope.choices[key].hI.setHours($scope.choices[key].hI.getHours() - $scope.choices[key].hI.getTimezoneOffset() / 60);;
        $scope.choices[key].hF.setHours($scope.choices[key].hF.getHours() - $scope.choices[key].hF.getTimezoneOffset() / 60);;
      });
      var totalHoras = $scope.choices.totalHoras;
      var msg = $scope.choices.mensaje;
      var id = $scope.idCaso;
      var data = new FormData();
      var adjuntoFoto = ( typeof $scope.files ==="undefined")?false:true;
      if (!adjuntoFoto) {
        alert("Debes adjuntar un registro");
      } else {
        for (var i in $scope.files) {
          console.log($scope.files[i]);
          data.append("documentos", $scope.files[i]);
        }
        var registros = JSON.stringify($scope.choices);
        data.append("registros", registros);
        data.append("totalH", totalHoras);
        data.append("msg", msg);
        data.append("idCaso", id);
        console.log(id);
        tutorsFactory.saveRegistry(data).then(function (respuesta) {
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
      }
    };

    //TRAER LOS DETALLES DE LAS HORAS DEL REGISTRO SELECCIONADO
    $scope.getDetalesRegistro = function (idRegistro, resumen, totalHoras, comPadre, username) {
      var idCaso = $scope.idCaso;
      $scope.resumen = resumen;
      $scope.idRegistro = idRegistro;
      $scope.totalH = totalHoras;
      $scope.comPadre = comPadre;
      $scope.answeredP = (comPadre !== '') ? false : true;
      $scope.username = username;

      tutorsFactory.detalleRegistros(idRegistro,idCaso).then(function (respuesta) {
        $scope.enlace=respuesta.data.enlace;
        $scope.nombreEnlace=respuesta.data.nombreEnlace;
        delete respuesta.data.enlace;
        delete respuesta.data.nombreEnlace;
        $scope.horas = respuesta.data;
      });
    };

    //CARGAR LOS DOCUMENTOS QUE ADJUNTE EL TUTOR
    $scope.getFileDetails = function (e) {

      $scope.files = [];
      $scope.$apply(function () {

        // STORE THE FILE OBJECT IN AN ARRAY.
        for (var i = 0; i < e.files.length; i++) {
          $scope.files.push(e.files[i]);
        }

      });
    };

  }]);
