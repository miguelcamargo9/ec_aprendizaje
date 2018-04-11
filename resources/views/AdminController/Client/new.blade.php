@extends('index')

@section('contentbody')
<div class="box box-info" ng-app="appClient">
  <div class="box-header">
    <i class="fa fas fa-suitcase"></i>

    <h3 class="box-title">Crear Cliente</h3>
    <!-- tools box -->
    <div class="pull-right box-tools">
    </div>
    <!-- /. tools -->
  </div>
  <div class="box-body" ng-controller="clientsCtrl">
    <!--<form method="POST" action="/tickets/registry" >-->
    <input type="hidden" name="_token" value="{{ csrf_token()}}"  />
    <div class="form-group" ng-class="{'has-feedback has-error': error.name}">
      <b>Nombres Primer Responsable:</b> 
      <input type="text" class="form-control" placeholder="Digite el Nombre del Primer Responsable:" ng-model='name' ng-change="error.name = false">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.name"></span>
      <span style="color: #ff0911" ng-show="error.name">Este campo es obligatorio, digite los nombres del responsable</span>
    </div>
    <div class="form-group" ng-class="{'has-feedback has-error': error.lastname}">
      <b>Apellidos Primer Responsable:</b> 
      <input type="text" class="form-control" placeholder="Digite el Apellido del Primer Responsable:" ng-model='lastname' ng-change="error.lastname = false">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.lastname"></span>
      <span style="color: #ff0911" ng-show="error.lastname">Este campo es obligatorio, digite los apellidos del responsable</span>
    </div>
    <div class="form-group" ng-class="{'has-feedback has-error': error.identification_number}">
      <b>Número de Indentificación:</b> 
      <input type="text" class="form-control" placeholder="Digite el Número de Indentificación del Responsable:" ng-model='identification_number' 
             ng-change="error.identification_number = false">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.identification_number"></span>
      <span style="color: #ff0911" ng-show="error.identification_number">Este campo es obligatorio, digite el número de identificación del responsable</span>
    </div>
    <div class="form-group" ng-class="{'has-feedback has-error': error.email}">
      <b>Correo:</b> 
      <input type="text" class="form-control" placeholder="Digite el Correo del Responsable:" ng-model='email' ng-change="error.email = false">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.email"></span>
      <span style="color: #ff0911" ng-show="error.email">Este campo es obligatorio, digite el correo del responsable</span>
    </div>
    <div class="form-group" ng-class="{'has-feedback has-error': error.namesecond}">
      <b>Nombres Segundo Responsable:</b>  
      <input type="text" class="form-control" placeholder="Digite el Nombre del Segundo Responsable:" ng-model='namesecond'
             ng-change="error.namesecond = false">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.namesecond"></span>
      <span style="color: #ff0911" ng-show="error.namesecond">Este campo es obligatorio, digite el nombre del segundo responsable</span>
    </div>
    <div class="form-group" ng-class="{'has-feedback has-error': error.lastnamesecond}">
      <b>Apellidos Segundo Responsable:</b> 
      <input type="text" class="form-control" placeholder="Digite el Apellido del Segundo Responsable:" ng-model='lastnamesecond'
             ng-change="error.lastnamesecond = false">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.lastnamesecond"></span>
      <span style="color: #ff0911" ng-show="error.lastnamesecond">Este campo es obligatorio, digite el apellido del segundo responsable</span>
    </div>
    <div class="form-group" ng-class="{'has-feedback has-error': error.identification_number_second}">
      <b>Número de Indentificación:</b> 
      <input type="text" class="form-control" placeholder="Digite el Número de Indentificación del segundo responsable:" 
             ng-model='identification_number_second' ng-change="error.identification_number_second = false">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.identification_number_second"></span>
      <span style="color: #ff0911" ng-show="error.identification_number_second">
        Este campo es obligatorio, digite el número de identificación del segundo responsable</span>
    </div>
    <div class="form-group" ng-class="{'has-feedback has-error': error.email_second}">
      <b>Correo:</b> 
      <input type="text" class="form-control" placeholder="Digite el Correo del segundo responsable:" ng-model='email_second' 
             ng-change="error.email_second = false">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.email_second"></span>
      <span style="color: #ff0911" ng-show="error.email_second">Este campo es obligatorio, digite el correo del segundo responsable</span>
    </div>
    <div class="form-group" >
      <div class="panel panel-default">
        <div class="panel-heading">Hijos</div>
        <div class="panel-body">
          <div class="form-group" ng-repeat="child in children track by $index">
            <div class="form-group row">
              <div class="col-xs-4" ng-class="{'has-feedback has-error': child.error.name}">
                <b>Nombre Hijo:</b> 
                <input type="text" class="form-control" placeholder="Digite el Nombre del Hijo:" ng-model='child.name' 
                       ng-change="child.error.name = false">
                <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="child.error.name"></span>
                <span style="color: #ff0911" ng-show="child.error.name">Este campo es obligatorio, digite el nombre del hijo</span>
              </div>
              <div class="col-xs-5" ng-class="{'has-feedback has-error': child.error.school}">
                <b>Colegio:</b> 
                <input type="text" class="form-control" placeholder="Digite el Colegio del Hijo:" ng-model='child.school' 
                       ng-change="child.error.school = false">
                <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="child.error.school"></span>
                <span style="color: #ff0911" ng-show="child.error.school">Este campo es obligatorio, digite el colegio del hijo</span>
              </div>
              <div class="col-xs-2" ng-class="{'has-feedback has-error': child.error.calendar}">
                <b>Calendario:</b><br> 
                <label class="radio-inline"><input type="radio" value="A" ng-model="child.calendar">A</label>
                <label class="radio-inline"><input type="radio" value="B" ng-model="child.calendar">B</label>
                <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="child.error.calendar"></span>
                <span style="color: #ff0911" ng-show="child.error.calendar">Este campo es obligatorio, seleccione el calendario</span>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-xs-2" ng-class="{'has-feedback has-error': child.error.course}">
                <b>Curso:</b> 
                <input type="number" class="form-control"  ng-model='child.course' ng-change="child.error.course = false">
                <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="child.error.course"></span>
                <span style="color: #ff0911" ng-show="child.error.course">Este campo es obligatorio, digite el curso.</span>
              </div>
              <div class="col-xs-3" ng-class="{'has-feedback has-error': child.error.burndate}">
                <b>Fecha de Nacimiento:</b> 
                <input type="date" class="form-control"  ng-model='child.burndate' ng-change="child.error.burndate = false; calculateAge(child)">
                <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="child.error.burndate"></span>
                <span style="color: #ff0911" ng-show="child.error.burndate">Este campo es obligatorio, seleccione la fecha de nacimeinto.</span>
              </div>
              <div class="col-xs-2">
                <b>Hora de Nacimiento:</b> 
                <input type="time" class="form-control"  ng-model='child.burntime'>
              </div>
              <div class="col-xs-2">
                <b>Edad:</b> 
                <input type="text" class="form-control"  ng-model='child.age' readonly>
              </div>
              <div class="col-xs-3 lostop">
                <br>
                <button type="button" class="btn btn-default btn-sm"  ng-show="showAddChild(child)" ng-click="addNewChild()">
                  <span class="glyphicon glyphicon-plus"></span> Agregar
                </button>
                <button type="button" class="btn btn-default btn-sm" ng-click="removeNewChild($index)">
                  <span class="glyphicon glyphicon-minus"></span> Borrar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer clearfix">
      <button type="submit" class="pull-right btn btn-success" id="accept" ng-click="validate('add')">Crear
        <i class="fa fa-arrow-circle-right"></i></button>
    </div>
    <div ng-repeat="errorObj in error.msjs">
      <div class="alert alert-danger" role="alert" ng-repeat="msj in errorObj">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        <strong><%msj%></strong>
      </div>
    </div>
    <div class="alert alert-success" role="alert" ng-show="success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
      <span class="sr-only">Error:</span>
      <strong><%success%></strong>
    </div>
    <!--</form>-->
  </div>
</div>
@endsection

@section('scriptsjs')
<!-- AdminLTE for demo purposes -->
<script src="/packages/adminLTE/dist/js/demo.js"></script>

<link href="/packages/ui-select-master/dist/select.css" rel="stylesheet">
<script src="//code.angularjs.org/1.2.20/angular-sanitize.min.js"></script>
<script src="/js/adminController/client/clientsController.js"></script>
<script src="/js/adminController/client/clientsFactory.js"></script>
<script src="/packages/ui-select-master/dist/select.js"></script>
@endsection
