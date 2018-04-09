@extends('index')

@section('contentbody')

<div class="box box-info" ng-app="app">
    <div class="box-header">
        <i class="fa fa-ticket"></i>

        <h3 class="box-title">Crear Proceso</h3>
        <!-- tools box -->
        <div class="pull-right box-tools">
            <!--            <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>-->
        </div>
        <!-- /. tools -->
    </div>
    <div class="box-body" ng-controller="ticketCtrl">
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
        <!--<form method="POST" action="/tickets/registry" >-->
        <input type="hidden" name="_token" value="{{{ csrf_token()}}}"  />
        <div  class="form-group" ng-class="{'has-feedback has-error': error.client}">
            <b>Estudiante: </b> <ui-select ng-model="client" theme="bootstrap" on-select="setClient($select.selected)">
                <ui-select-match placeholder="Seleccione un Estudiante"><% client.child.nombre %> <% client.child.apellido %> - (Padre) <% client.father.name %></ui-select-match>
                <ui-select-choices repeat="client in clients | filter: $select.search">
                    <span ng-bind-html="client.child.nombre | highlight: $select.search"></span> <span ng-bind-html="client.child.apellido | highlight: $select.search"></span> - (Padre) 
                    <small ng-bind-html="client.father.name | highlight: $select.search"></small>
                </ui-select-choices>
            </ui-select>
            <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.client"></span>
            <span style="color: #ff0911" ng-show="error.client">Este campo es obligatorio, seleccione un estudiante</span>
        </div>
        <div  class="form-group" ng-class="{'has-feedback has-error': error.tutor}">
            <b>Tutor</b> <ui-select ng-model="tutor" theme="bootstrap" on-select="setTutor($select.selected)">
                <ui-select-match placeholder="Seleccione un Tutor"><% tutor.name %> - <% tutor.email %></ui-select-match>
                <ui-select-choices repeat="tutor in tutors | filter: $select.search">
                    <span ng-bind-html="tutor.name | highlight: $select.search"></span>
                    <small ng-bind-html="tutor.email | highlight: $select.search"></small>
                </ui-select-choices>
            </ui-select>
            <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.tutor"></span>
            <span style="color: #ff0911" ng-show="error.tutor">Este campo es obligatorio, seleccione un tutor</span>
        </div>
        
        <!--fecha de inicio i finalizacion-->
        <div class="row">
          <!--fecha de inicio-->
          <div class="col-xs-6">
            <div class="form-group" ng-class="{'has-feedback has-error': error.initdate}">
                <b>Fecha Inicial: </b> <input type="date" class="form-control" id='initdate' name="initdate" placeholder="Fecha Inicial:" ng-model='initdate' ng-change="error.initdate = false">
                <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.initdate"></span>
                <span style="color: #ff0911" ng-show="error.initdate">Este campo es obligatorio, seleccione la fecha inicial del proceso</span>
            </div>
          </div>
          <!--fecha de fin-->
          <div class="col-xs-6">
            <div class="form-group">
                <b>Fecha Final;</b> <input type="date" class="form-control" id='enddate' name="enddate" placeholder="Fecha Final:" ng-model='enddate'>
            </div>
          </div>
        </div>
        
        <!--DATOS DE FACTURACION-->
        <h2>Datos de cobro</h2>
        
        <div class="row">
          <!--NOMBRE FACTURA-->
          <div class="col-xs-6">
            <div class="form-group" ng-class="{'has-feedback has-error': error.nombre}">
                <b>Factura a nombre de Natural/Empresa </b> 
                <input type="text" class="form-control" id='nombre' name="nombre"  ng-model='factura.nombre' ng-change="error.nombre = false">
                <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.nombre"></span>
                <span style="color: #ff0911" ng-show="error.nombre">Este campo es obligatorio, seleccione la fecha inicial del proceso</span>
            </div>
          </div>
          <!--DIRECCION FACTURA-->
          <div class="col-xs-6">
            <div class="form-group" ng-class="{'has-feedback has-error': error.direccion}">
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
            <div class="form-group" ng-class="{'has-feedback has-error': error.nit}">
                <b>NIT o cédula de factura </b> 
                <input type="text" class="form-control" id='nit' name="nit"  ng-model='factura.nit' ng-change="error.nit = false">
                <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.nit_factura"></span>
                <span style="color: #ff0911" ng-show="error.nit">Este campo es obligatorio</span>
            </div>
          </div>
          <!--DIRECCION FACTURA-->
          <div class="col-xs-6">
            <div class="form-group">
                <b>Teléfono fijo</b> 
                <input type="text" class="form-control" id='telefono_factura' name="telefono_factura"  ng-model='factura.telefono'>
            </div>
          </div>
        </div>
        
        <div class="row">
          <!--NOMBRE FACTURA-->
          <div class="col-xs-6">
            <div class="form-group" ng-class="{'has-feedback has-error': error.ciudad}">
                <b>Ciudad </b> 
                <input type="text" class="form-control" id='ciudad' name="ciudad"  ng-model='factura.ciudad' ng-change="error.ciudad = false">
                <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.ciudad_factura"></span>
                <span style="color: #ff0911" ng-show="error.ciudad">Este campo es obligatorio</span>
            </div>
          </div>
          <!--DIRECCION FACTURA-->
          <div class="col-xs-6">
            <div class="form-group">
                <b>Correo electronico</b> 
                <input type="email" class="form-control" id='email_factura' name="email_factura"  ng-model='factura.email'>
            </div>
          </div>
        </div>
        
        <div class="box-footer clearfix">
            <button type="submit" class="pull-right btn btn-success" id="accept" ng-click="validate('add')">Crear
                <i class="fa fa-arrow-circle-right"></i></button>
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
<script src="/js/ticketsController/ticketsController.js"></script>
<script src="/js/ticketsController/ticketsFactory.js"></script>
<script type="text/javascript" src="/packages/ui-select-master/dist/select.js"></script>

@endsection
