@extends('index')

@section('contentbody')
<style>
  .full button span {
    background-color: limegreen;
    border-radius: 32px;
    color: black;
  }
  .partially button span {
    background-color: orange;
    border-radius: 32px;
    color: black;
  }
</style>
<div class="box box-info" ng-app="app">
  <div class="box-header">
    <i class="fa fa-ticket"></i>
    <h3 class="box-title">Editar Proceso</h3>
  </div>
  <div class="box-body" ng-controller="ticketCtrl">
    <!--<form method="POST" action="/tickets/registry" >-->
    <input type="hidden" name="_token" value="{{ csrf_token()}}"  />
    <input type="hidden" name="casoId" ng_model = "casoId" ng-init="casoId = {{ $id }}"  />
    <!--SELECCIONAR EL ESTUDIANTE-->
    <div class="form-group" ng-class="{'has-feedback has-error': error.client}" ng-init="idclient = {{$id_cliente}}">
      <b>Estudiante: </b> 
      <ui-select ng-model="client.selected" theme="bootstrap" on-select="setClient($select.selected)" ng-disabled="true">
        <ui-select-match placeholder="Seleccione un Estudiante"><% client.selected.child.nombre %> <% client.selected.child.apellido %> - (Padre) <% client.selected.father.name %></ui-select-match>
        <ui-select-choices repeat="client in clients | filter: $select.search">
          <span ng-bind-html="client.child.nombre | highlight: $select.search"></span> <span ng-bind-html="client.child.apellido | highlight: $select.search"></span> - (Padre) 
          <small ng-bind-html="client.father.name | highlight: $select.search"></small>
        </ui-select-choices>
      </ui-select>
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.client"></span>
      <span style="color: #ff0911" ng-show="error.client">Este campo es obligatorio, seleccione un estudiante</span>
    </div>

    <!--SELECCIONAR EL TUTOR-->
    <div  class="form-group">
      <div class="panel panel-default">
        <div class="panel-heading">Tutores</div>
        <div class="panel-body" ng-init="tutorsselected = {{htmlspecialchars(json_encode($tutors))}}">
          <div class="form-group" ng-repeat="mytutor in tutorsselected track by $index">
            <div class="form-group row" ng-init="mytutor.tutor = mytutor.user">
              <div class="col-xs-6" ng-class="{'has-feedback has-error': mytutor.error.name}">
                <b>Seleccion a un tutor:</b>
                <ui-select ng-model="$parent.mytutor.tutor" theme="bootstrap" on-select="$parent.mytutor.error.name = false">
                  <ui-select-match placeholder="Seleccione un Tutor"><% mytutor.tutor.name %> - <% mytutor.tutor.email %></ui-select-match>
                  <ui-select-choices repeat="tutor in tutors | filter: $select.search">
                    <span ng-bind-html="tutor.name | highlight: $select.search"></span>
                    <small ng-bind-html="tutor.email | highlight: $select.search"></small>
                  </ui-select-choices>
                </ui-select>
                <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="mytutor.error.name"></span>
                <span style="color: #ff0911" ng-show="mytutor.error.name">Este campo es obligatorio, seleccione un tutor</span>
              </div>
              <div class="col-xs-3 lostop">
                <br>
                <button type="button" class="btn btn-default btn-sm"  ng-show="showAddTutor(mytutor)" ng-click="addNewTutor()">
                  <span class="glyphicon glyphicon-plus"></span> Agregar
                </button>
                <button type="button" class="btn btn-default btn-sm" ng-click="removeNewTutor($index)">
                  <span class="glyphicon glyphicon-minus"></span> Borrar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--fecha de inicio y finalizacion-->
    <div class="row">
      <!--fecha de inicio-->
      <div class="col-xs-4">
        <div class="form-group">
          <b>Fecha Inicial: </b> 
          <p class="input-group">
            <input type="text" class="form-control" id='initdate' name="initdate" value="{{$fecha_inicio}}" readonly/>
          </p>
        </div>
      </div>
    </div>

    <!--DATOS DE FACTURACION-->
    <div class="box-header">
      <i class="fa fa-money"></i>
      <h3 class="box-title">Datos de cobro</h3>
    </div>

    <div class="row">
      <!--NOMBRE FACTURA-->
      <div class="col-xs-6">
        <div class="form-group" ng-class="{'has-feedback has-error': error.nombre}" ng-init="factura.nombre = '{{$invoice->nombre}}'">
          <b>Factura a nombre de Natural/Empresa </b> 
          <input type="text" class="form-control" id='nombre' name="nombre"  ng-model='factura.nombre' ng-change="error.nombre = false">
          <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.nombre"></span>
          <span style="color: #ff0911" ng-show="error.nombre">Este campo es obligatorio, seleccione la fecha inicial del proceso</span>
        </div>
      </div>
      <!--DIRECCION FACTURA-->
      <div class="col-xs-6">
        <div class="form-group" ng-class="{'has-feedback has-error': error.direccion}" ng-init="factura.direccion = '{{$invoice -> direccion}}'">
          <b>Direccion de la factura Persona/Empresa</b> 
          <input type="text" class="form-control" id='direccion' name="direccion"  ng-model='factura.direccion' ng-change="error.direccion = false">
          <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.direccion"></span>
          <span style="color: #ff0911" ng-show="error.direccion">Este campo es obligatorio</span>
        </div>
      </div>
    </div>

    <div class="row">
      <!--NOMBRE FACTURA-->
      <div class="col-xs-6">
        <div class="form-group" ng-class="{'has-feedback has-error': error.nit}" ng-init="factura.nit = '{{$invoice -> nit}}'">
          <b>NIT o cédula de factura </b> 
          <input type="text" class="form-control" id='nit' name="nit"  ng-model='factura.nit' ng-change="error.nit = false">
          <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.nit_factura"></span>
          <span style="color: #ff0911" ng-show="error.nit">Este campo es obligatorio</span>
        </div>
      </div>
      <!--DIRECCION FACTURA-->
      <div class="col-xs-6">
        <div class="form-group" ng-init="factura.telefono = '{{$invoice -> telefono}}'">
          <b>Teléfono fijo</b> 
          <input type="text" class="form-control" id='telefono_factura' name="telefono_factura"  ng-model='factura.telefono'>
        </div>
      </div>
    </div>

    <div class="row">
      <!--NOMBRE FACTURA-->
      <div class="col-xs-6">
        <div class="form-group" ng-class="{'has-feedback has-error': error.ciudad}" ng-init="factura.ciudad = '{{$invoice -> ciudad}}'">
          <b>Ciudad </b> 
          <input type="text" class="form-control" id='ciudad' name="ciudad"  ng-model='factura.ciudad' ng-change="error.ciudad = false">
          <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.ciudad_factura"></span>
          <span style="color: #ff0911" ng-show="error.ciudad">Este campo es obligatorio</span>
        </div>
      </div>
      <!--DIRECCION FACTURA-->
      <div class="col-xs-6">
        <div class="form-group" ng-init="factura.email = '{{$invoice -> email}}'">
          <b>Correo electronico</b> 
          <input type="email" class="form-control" id='email_factura' name="email_factura"  ng-model='factura.email'>
        </div>
      </div>
    </div>

    <div class="box-footer clearfix">
      <button type="submit" class="pull-right btn btn-warning" id="accept" ng-click="validate('edit')">Editar
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
<script src="/packages/ui-bootstrap/ui-bootstrap-tpls-2.5.0.min.js"></script>
<link href="/packages/ui-select-master/dist/select.css" rel="stylesheet">
<script src="//code.angularjs.org/1.2.20/angular-sanitize.min.js"></script>
<script src="/js/ticketsController/ticketsController.js"></script>
<script src="/js/ticketsController/ticketsFactory.js"></script>
<script type="text/javascript" src="/packages/ui-select-master/dist/select.js"></script>

@endsection
