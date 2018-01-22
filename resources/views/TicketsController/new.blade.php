@extends('index')

@section('contentbody')
<?php
$visible = (isset($mensaje) && $mensaje != '') ? "display:block;" : "display:none;";
?>
<div class="alert alert-success" role="alert" style="{{$visible}}">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <span class="sr-only">Error:</span>
    <strong>{{$mensaje}}</strong>
</div>
<div class="box box-info" ng-app="app">
    <div class="box-header">
        <i class="fa fa-ticket"></i>

        <h3 class="box-title">Crear Caso</h3>
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
        </div>
        <!-- /. tools -->
    </div>
    <div class="box-body" ng-controller="ticketCtrl">
        <form method="POST" action="/tickets/registry" >
            <input type="hidden" name="_token" value="{{{ csrf_token()}}}"  />
            <div  class="form-group">
                Estudiante <ui-select ng-model="client" theme="bootstrap" on-select="setClient($select.selected)">
                    <ui-select-match placeholder="Seleccione un Cliente"><% client.child.nombre %> <% client.child.apellido %> - (Padre) <% client.father.name %></ui-select-match>
                    <ui-select-choices repeat="client in clients | filter: $select.search">
                        <span ng-bind-html="client.child.nombre | highlight: $select.search"></span> <span ng-bind-html="client.child.apellido | highlight: $select.search"></span> - (Padre) 
                        <small ng-bind-html="client.father.name | highlight: $select.search"></small>
                    </ui-select-choices>
                </ui-select>
            </div>
            <input type="text" name="id_cliente" ng-model="cliente" ng-show="false">
            <div class="form-group">
                Fecha Inicial <input type="date" class="form-control" id='initdate' name="dateini" placeholder="Fecha Inicial:" required>
            </div>
            <div class="form-group">
                Fecha Final <input type="date" class="form-control" id='enddate' name="dateend" placeholder="Fecha Final:" required>
            </div>
            <!--            <div>
                            <textarea name='description' class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                        </div>-->
            <div class="box-footer clearfix">
                <button type="submit" class="pull-right btn btn-default" id="accept">Crear
                    <i class="fa fa-arrow-circle-right"></i></button>
            </div>
        </form>
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
