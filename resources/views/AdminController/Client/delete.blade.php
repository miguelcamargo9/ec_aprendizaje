@extends('index')

@section('contentbody')
<div class="box box-info" ng-app="appTutor">
    <div class="box-header">
        <i class="fa fa-ticket"></i>

        <h3 class="box-title">Borrar Tutor</h3>
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
            <input type="text" class="form-control" ng-model='university' ng-init="university = '{{$universidad}}'" readonly>
        </div>
        <div class="form-group">
            <b>Carrera:</b> 
            <input type="text" class="form-control" ng-model='degree' ng-init="degree = '{{$carrera}}'" readonly>
        </div>
        <div class="form-group">
            <b>Semestre:</b> 
            <input type="text" class="form-control" ng-model='semester' ng-init="semester = '{{$semestre}}'" readonly>
        </div>
        <div class="form-group">
            <b>Valor por Hora:</b> 
            <input type="text" class="form-control" ng-model='valxhour' ng-init="valxhour = '{{$valor_hora}}'" readonly>
        </div>
        <div class="form-group">
            <b>Celular:</b> 
            <input type="text" class="form-control" ng-model='mobile' ng-init="mobile = '{{$celular}}'" readonly>
        </div>
        <div class="form-group">
            <b>Número de Cuenta:</b> 
            <input type="text" class="form-control" ng-model='accountnumber' ng-init="accountnumber = '{{$numero_cuenta}}'" readonly>
        </div>
        <input type="hidden" ng-init="idtutor = {{$id}}" ng-model="idtutor">
        <input type="hidden" ng-init="iduser = {{$user['id']}}" ng-model="iduser">
        <div class="box-footer clearfix">
            <button type="submit" class="pull-right btn btn-danger" id="accept" ng-click="deleteTutor()">Eliminar
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
<script src="/js/adminController/tutorsController.js"></script>
<script src="/js/adminController/tutorsFactory.js"></script>
<script src="/packages/ui-select-master/dist/select.js"></script>
@endsection
