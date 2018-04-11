@extends('index')

@section('contentbody')
<div class="box box-info" ng-app="appClient">
  <div class="box-header">
    <i class="fa fas fa-suitcase"></i>
    <h3 class="box-title">Eliminar Cliente</h3>
  </div>
  <div class="box-body" ng-controller="clientsCtrl">
    <!--<form method="POST" action="/tickets/registry" >-->
    <input type="hidden" name="_token" value="{{ csrf_token()}}"  />
    <div class="form-group">
      <b>Nombres Primer Responsable:</b> 
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
      <b>Nombres Segundo Responsable:</b>  
      <input readonly type="text" class="form-control" ng-model='namesecond'
             @if(isset($usertwo))
             ng-init="namesecond = '{{$usertwo['name']}}'"
             @endif 
             >
    </div>
    <div class="form-group">
      <b>Número de Indentificación:</b> 
      <input readonly type="text" class="form-control" ng-model='identification_number_second'  
             @if(isset($usertwo))
             ng-init="identification_number_second = '{{$usertwo['identification_number']}}'"
             @endif 
             >
    </div>
    <div class="form-group">
      <b>Correo:</b> 
      <input readonly type="text" class="form-control" ng-model='email_second' 
             @if(isset($usertwo))
             ng-init="email_second = '{{$usertwo['email']}}'"
             @endif
             >
    </div>
    <div class="form-group" >
      <div class="panel panel-default">
        <div class="panel-heading">Hijos</div>
        <div class="panel-body" ng-init="children = {{htmlspecialchars(json_encode($children))}}">
          <div class="form-group" ng-repeat="child in children track by $index">               
            <div class="row">
              <div class="form-group row">
                <div class="col-xs-4">
                  <b>Nombre Hijo:</b> 
                  <input type="text" class="form-control" ng-model='child.name' ng-init='child.name = child.child.nombre;' readonly>  
                </div>
                <div class="col-xs-5">
                  <b>Colegio:</b> 
                  <input type="text" class="form-control"  ng-model='child.school' ng-init='child.school = child.child.colegio;' readonly>
                </div>
                <div class="col-xs-2">
                  <b>Calendario:</b><br> 
                  <label class="radio-inline"><input type="radio" value="A" ng-model="child.calendar" ng-init='child.calendar = child.child.calendario;' disabled>A</label>
                  <label class="radio-inline"><input type="radio" value="B" ng-model="child.calendar" disabled>B</label>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-xs-2">
                  <b>Curso:</b> 
                  <input type="number" class="form-control"  ng-model='child.course' ng-init='child.course = child.child.curso;' readonly>
                </div>
                <div class="col-xs-3">
                  <b>Fecha de Nacimiento:</b>
                  <input type="date" class="form-control"  ng-model='child.burndate' ng-init='child.burndate = Date(child.child.fecha_nacimiento);' readonly>
                </div>
                <div class="col-xs-2">
                  <b>Hora de Nacimiento:</b> 
                  <input type="time" class="form-control"  ng-model='child.burntime' ng-init='child.burntime = Date(child.child.hora_nacimiento);' readonly>
                </div>
                <div class="col-xs-2">
                  <b>Edad:</b> 
                  <input type="text" class="form-control"  ng-model='child.age' ng-init='child.age = child.child.edad;' readonly>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" ng-init="idfather = {{$id}}" ng-model="idfather">
    <input type="hidden" ng-init="iduser = {{$user['id']}}" ng-model="iduser">
    @if(isset($usertwo))
    <input type="hidden" ng-init="idusertwo = {{$usertwo['id']}}" ng-model="idusertwo">
    @endif 
    <div class="box-footer clearfix">
      <button type="submit" class="pull-right btn btn-danger" id="accept" ng-click="deleteClient()">Eliminar
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
