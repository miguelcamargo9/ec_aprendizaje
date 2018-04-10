@extends('index')

@section('contentbody')
<div class="box box-info" ng-app="appTutor">
  <div class="box-header">
    <i class="fa fa-ticket"></i>

    <h3 class="box-title">Activar Tutor</h3>
    <!-- tools box -->
    <div class="pull-right box-tools">
    </div>
    <!-- /. tools -->
  </div>
  <div class="box-body" ng-controller="tutorsCtrl">
    <!--<form method="POST" action="/tickets/registry" >-->
    <input type="hidden" name="_token" value="{{ csrf_token()}}"  />

    <div class="form-group">
      <b>Nombre:</b> 
      <input type="text" class="form-control" ng-model='name' ng-init="name = '{{$user['name']}}'" readonly>
    </div>
    <div class="form-group">
      <b>Número de Indentificación:</b> 
      <input type="text" class="form-control" ng-model='identification_number' ng-init="identification_number = '{{$user['identification_number']}}'" readonly>
    </div>
    <div class="form-group">
      <b>Correo:</b> 
      <input type="text" class="form-control" ng-model='email' ng-init="email = '{{$user['email']}}'" readonly>
    </div>
    <div class="form-group">
      <b>Universidad:</b> 
      <input type="text" class="form-control" ng-model='university' ng-init="university = '{{$university['universidad']}}'" readonly>
    </div>
    <div class="form-group">
      <b>Carrera:</b> 
      <input type="text" class="form-control" ng-model='degree' ng-init="degree = '{{$degree['carrera']}}'" readonly>
    </div>
    <div class="form-group row">
      <div class="col-xs-1">
        <b>Graduado:</b> 
        <input type="checkbox" class="form-check-input" ng-model='graduate' ng-init="graduate = @if ($graduado === 1) true @else false @endif" disabled>
      </div>
      <div class="col-xs-2" ng-show="!graduate">
        <b>Semestre:</b> 
        <input type="number" class="form-control" ng-model='semester' ng-init="semester = {{$semestre}}" readonly>
      </div>
      <div class="col-xs-5">
        <b>Celular:</b> 
        <input type="text" class="form-control" ng-model='mobile' ng-init="mobile = '{{$celular}}'" readonly>
      </div>
      <div class="col-xs-2">
        <b>Permitir Registro Pasado:</b> 
        <input type="checkbox" class="form-check-input" ng-model='pastregister' ng-init="pastregister = @if ($permiso_registro === 'SI') true @else false @endif" disabled>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-xs-4" ng-class="{'has-feedback has-error': error.accountnumber}">
        <b>Número de Cuenta:</b> 
        <input type="text" class="form-control" ng-model='accountnumber' ng-init="accountnumber = '{{$numero_cuenta}}'" readonly>
      </div>
      <div class="col-xs-4">
        <b>Tipo de Cuenta:</b> 
        <input type="text" class="form-control" ng-model='accounttype' ng-init="accounttype = '{{$tipo_cuenta}}'" readonly>
      </div>
      <div class="col-xs-4">
        <b>Banco: </b> 
        <input type="text" class="form-control" ng-model='bank' ng-init="bank = '{{$bank['banco']}}'" readonly>
      </div>
    </div>
    <input type="hidden" ng-init="idtutor = {{$id}}" ng-model="idtutor">
    <input type="hidden" ng-init="iduser = {{$user['id']}}" ng-model="iduser">
    <div class="box-footer clearfix">
      <button type="submit" class="pull-right btn btn-success" id="accept" ng-click="activateTutor()">Activar
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
<script src="/js/adminController/tutor/tutorsController.js"></script>
<script src="/js/adminController/tutor/tutorsFactory.js"></script>
<script src="/packages/ui-select-master/dist/select.js"></script>
@endsection
