@extends('index')

@section('contentbody')
<div class="box box-info" ng-app="appTutor">
  <div class="box-header">
    <i class="fa fa-ticket"></i>
    <h3 class="box-title">Editar Tutor</h3>
  </div>
  <div class="box-body" ng-controller="tutorsCtrl">
    <?php $semestre = (isset($semestre)) ? $semestre : 0; ?>
    <input type="hidden" name="_token" value="{{ csrf_token()}}"  />

    <div class="form-group" ng-class="{'has-feedback has-error': error.name}">
      <b>Nombre:</b> 
      <input type="text" class="form-control" placeholder="Digite el Nombre del Tutor:" ng-model='name' ng-change="error.name = false" 
             ng-init="name = '{{$user['name']}}'">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.name"></span>
      <span style="color: #ff0911" ng-show="error.name">Este campo es obligatorio, digite el nombre del tutor</span>
    </div>
    <div class="form-group" ng-class="{'has-feedback has-error': error.identification_number}">
      <b>Número de Indentificación:</b> 
      <input type="text" class="form-control" placeholder="Digite el Número de Indentificación del Tutor:" ng-model='identification_number' 
             ng-change="error.identification_number = false" ng-init="identification_number = '{{$user['identification_number']}}'">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.identification_number"></span>
      <span style="color: #ff0911" ng-show="error.identification_number">Este campo es obligatorio, digite el número de identificación del tutor</span>
    </div>
    <div class="form-group" ng-class="{'has-feedback has-error': error.email}">
      <b>Correo:</b> 
      <input type="text" class="form-control" placeholder="Digite el Correo del Tutor:" ng-model='email' ng-change="error.email = false" 
             ng-init="email = '{{$user['email']}}'">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.email"></span>
      <span style="color: #ff0911" ng-show="error.email">Este campo es obligatorio, digite el correo del tutor</span>
    </div>
    <div  class="form-group row" ng-init="iduniversity = {{$universidad_id}}">
      <div class="col-xs-9" ng-class="{'has-feedback has-error': error.university}">
        <b>Universidad: </b>
        <ui-select ng-model="university.selected" theme="bootstrap" on-select="setUniversity($select.selected)" >
          <ui-select-match placeholder="Seleccione una Universidad"><% university.selected.universidad %></ui-select-match>
          <ui-select-choices repeat="university in universities | filter: $select.search">
            <span ng-bind-html="university.universidad | highlight: $select.search"></span>
          </ui-select-choices>
        </ui-select>
        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.university"></span>
        <span style="color: #ff0911" ng-show="error.university">Este campo es obligatorio, seleccione la universidad del tutor</span>
      </div>
      <div class="col-xs-1">
        <b>Adicionar: </b>
        <button class="btn btn-info form-control" ng-click="viewnewuni = true">
          <i class="fa fa-plus-circle"></i>
        </button>
      </div>
    </div>
    <div class="form-group" ng-class="{'has-feedback has-error': error.university}" ng-show="viewnewuni">
      <b>Nueva Universidad:</b> 
      <input type="text" class="form-control" placeholder="Digite la Universidad del Tutor:" ng-model='newuniversity' ng-change="error.university = false">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.university"></span>
      <span style="color: #ff0911" ng-show="error.university">Este campo es obligatorio, digite la universidad del tutor</span>
    </div>
    <div  class="form-group row" ng-init="iddegree = {{$carrera_id}}">
      <div class="col-xs-9" ng-class="{'has-feedback has-error': error.degree}">
        <b>Carrera: </b> <ui-select ng-model="degree.selected" theme="bootstrap" on-select="setDegree($select.selected)">
          <ui-select-match placeholder="Seleccione una Carrera"><% degree.selected.carrera %></ui-select-match>
          <ui-select-choices repeat="degree in degrees | filter: $select.search">
            <span ng-bind-html="degree.carrera | highlight: $select.search"></span>
          </ui-select-choices>
        </ui-select>
        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.degree"></span>
        <span style="color: #ff0911" ng-show="error.degree">Este campo es obligatorio, seleccione la carrera del tutor</span>
      </div>
      <div class="col-xs-1">
        <b>Adicionar: </b>
        <button class="btn btn-info form-control" ng-click="viewnewdeg = true">
          <i class="fa fa-plus-circle"></i>
        </button>
      </div>
    </div>
    <div class="form-group" ng-class="{'has-feedback has-error': error.degree}" ng-show="viewnewdeg">
      <b>Nueva Carrera:</b> 
      <input type="text" class="form-control" placeholder="Digite la Carrera del Tutor:" ng-model='newdegree' ng-change="error.degree = false">
      <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.degree"></span>
      <span style="color: #ff0911" ng-show="error.degree">Este campo es obligatorio, digite la carrera del tutor</span>
    </div>
    <div class="form-group row">
      <div class="col-xs-1">
        <b>Graduado:</b> 
        <input type="checkbox" class="form-check-input" ng-model='graduate' ng-init="graduate = @if ($graduado === 1) true @else false @endif">
      </div>
      <div class="col-xs-2" ng-show="!graduate" ng-class="{'has-feedback has-error': error.semester}">
        <b>Semestre:</b> 
        <input type="number" class="form-control" placeholder="Digite el Semestre del Tutor:" ng-model='semester' ng-change="error.semester = false" 
               ng-init="semester = {{$semestre}}" min="1" max="20">
        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.semester"></span>
        <span style="color: #ff0911" ng-show="error.semester">Este campo es obligatorio, digite el semestre del tutor</span>
      </div>
      <div class="col-xs-5" ng-class="{'has-feedback has-error': error.mobile}">
        <b>Celular:</b> 
        <input type="text" class="form-control" placeholder="Digite el Celular del Tutor:" ng-model='mobile' ng-change="error.mobile = false"
               ng-init="mobile = '{{$celular}}'">
        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.mobile"></span>
        <span style="color: #ff0911" ng-show="error.mobile">Este campo es obligatorio, digite el celular del tutor<               /span>
      </div             >
      <div class="col-xs-2">
        <b>Permitir Registro Pasado:</b> 
        <input type="checkbox" class="form-check-input" ng-model='pastregister' ng-init="pastregister = @if ($permiso_registro === 'SI') true @else false @endif">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-xs-4" ng-class="{'has-feedback has-error': error.accountnumber}">
        <b>Número de Cuenta:</b> 
        <input type="text" class="form-control" placeholder="Digite el Número de Cuenta del Tutor:" ng-model='accountnumber' ng-change="error.accountnumber = false"
               ng-init="accountnumber = '{{$numero_cuenta}}'">
        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.accountnumber"></span>
        <span style="color: #ff0911" ng-show="error.accountnumber">Este campo es obligatorio, digite el número de cuenta del tutor</span>     
      </div>
      <div class="col-xs-4" ng-class="{'has-feedback has-error': error.accounttype}" ng-init="idaccounttype = '{{$tipo_cuenta}}'">
        <b>Tipo de Cuenta:</b> 
        <ui-select ng-model="accounttype.selected" theme="bootstrap" on-select="setAccountType($select.selected)">
          <ui-select-match placeholder="Seleccione un Tipo de Cuenta"><% accounttype.selected.name %></ui-select-match>
          <ui-select-choices repeat="accounttype in accounttypes | filter: $select.search">
            <span ng-bind-html="accounttype.name | highlight: $select.search"></span>
          </ui-select-choices>
        </ui-select>
        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.accounttype"></span>
        <span style="color: #ff0911" ng-show="error.accounttype">Este campo es obligatorio, seleccione el tipo de cuenta del tutor</span>   
      </div>
      <div class="col-xs-4" ng-class="{'has-feedback has-error': error.bank}" ng-init="idbank = {{$banco_id}}">
        <b>Banco: </b> 
        <ui-select ng-model="bank.selected" theme="bootstrap" on-select="setBank($select.selected)">
          <ui-select-match placeholder="Seleccione un Banco"><% bank.selected.banco %></ui-select-match>
          <ui-select-choices repeat="bank in banks | filter: $select.search">
            <span ng-bind-html="bank.banco | highlight: $select.search"></span>
          </ui-select-choices>
        </ui-select>
        <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.bank"></span>
        <span style="color: #ff0911" ng-show="error.bank">Este campo es obligatorio, seleccione el banco</span>
      </div>
    </div>
    <input type="hidden" ng-init="idtutor = {{$id}}" ng-model="idtutor">
    <input type="hidden" ng-init="iduser = {{$user['id']}}" ng-model="iduser">
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

<link href="/packages/ui-select-master/dist/select.css" rel="stylesheet">
<script src="//code.angularjs.org/1.2.20/angular-sanitize.min.js"></script>
<script src="/js/adminController/tutor/tutorsController.js"></script>
<script src="/js/adminController/tutor/tutorsFactory.js"></script>
<script src="/packages/ui-select-master/dist/select.js"></script>
@endsection
