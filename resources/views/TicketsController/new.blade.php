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
<div class="box box-info">
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
    <div class="box-body">
         <form method="POST" action="/tickets/registry">
            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
            <div ng-app="app" ng-controller="studentCtrl" class="form-group">
                Estudiante <select class="form-control" ng-model="selectedName" ng-options="x for x in names">
                </select>
            </div>
            <div class="form-group">
                Fecha Inicial <input type="date" class="form-control" id='initdate' name="dateini" placeholder="Fecha Inicial:" required>
            </div>
            <div class="form-group">
                Fecha Final <input type="date" class="form-control" id='enddate' name="dateend" placeholder="Fecha Final:" required>
            </div>
            <div>
                <textarea name='description' class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
            </div>
            <div class="box-footer clearfix">
                <button type="submit" class="pull-right btn btn-default" id="accept">Crear
                    <i class="fa fa-arrow-circle-right"></i></button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scriptsjs')
    <script>
        var app = angular.module('app', []);
        app.controller('studentCtrl', function($scope) {
            $scope.names = ["Emilio", "Tobias", "Samuel", "Pepito Perez"];
        });
    </script>
    <!-- AdminLTE for demo purposes -->
    <script src="/packages/adminLTE/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="/packages/adminLTE/dist/js/pages/dashboard.js"></script>
@endsection
