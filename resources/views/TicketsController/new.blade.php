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
        <div class="form-group" ng-class="{'has-feedback has-error': error.initdate}">
            <b>Fecha Inicial: </b> <input type="date" class="form-control" id='initdate' name="initdate" placeholder="Fecha Inicial:" ng-model='initdate' ng-change="error.initdate = false">
            <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="error.initdate"></span>
            <span style="color: #ff0911" ng-show="error.initdate">Este campo es obligatorio, seleccione la fecha inicial del proceso</span>
        </div>
        <div class="form-group">
            <b>Fecha Final;</b> <input type="date" class="form-control" id='enddate' name="enddate" placeholder="Fecha Final:" ng-model='enddate'>
        </div>
        <!--            <div>
                        <textarea name='description' class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                    </div>-->
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
