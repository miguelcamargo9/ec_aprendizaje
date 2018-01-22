@extends('index')

@section('contentbody')
<div class="alert alert-success" id="msg-done" role="alert" style="display: none">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <!--<span class="sr-only">Error:</span>-->
  <strong>Comentario guardado</strong>
</div>
<div class="box box-info">
  <div class="box-header">
    <i class="fa fa-ticket"></i>

    <h3 class="box-title">Informacion del caso</h3>
    <!-- tools box -->
    <div class="pull-right box-tools">
      <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove">
        <i class="fa fa-times"></i></button>
    </div>
    <!-- /. tools -->
  </div>
  <div class="box-body">
    <form action="#" method="post">
      <div class="form-group">
        Estudiante <input disabled type="text" class="form-control" value="{{$client_name}}" >
      </div>
      <div class="form-group">
        Fecha Inicial <input disabled type="date" class="form-control" value="{{$fecha_inicio}}" >
      </div>
      <div class="form-group">
        Fecha Final <input disabled type="date" class="form-control" value="{{$fecha_fin}}" >
      </div>
      <div class="row">
        @if($id_estado==3 || $id_estado==5)
        <div class="col-xs-6">
          <h4>Comentario del tutor:</h4>
          <textarea disabled class="textarea" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
            {{$descripcion}}
          </textarea>
        </div>
        <input type="hidden" name="idCaso" id="idCaso" value="{{$id}}"  />
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"  />
        <div class="col-xs-6">
          <h4>Comentario:</h4>

          <textarea {{$comentario_padre!==NULL ? "disabled" : ""}}  class="textarea" name="comentario" placeholder="Comentario" id="comentario"
            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$comentario_padre}}</textarea>
        </div>
        @endif
      </div>
    </form>
  </div>
  <div  class="box-footer clearfix">
    <button type="button" class="pull-right btn btn-default" id="btn-form-comentario">responder
      <i class="fa fa-share"></i></button>
  </div>
</div>
@endsection
@section('scriptsjs')
<script>
//        var app = angular.module('app', []);
//        app.controller('studentCtrl', function($scope) {
//            $scope.names = ["Emilio", "Tobias", "Samuel", "Pepito Perez"];
//        });
</script>
<!-- AdminLTE for demo purposes -->
<!--<script src="/packages/adminLTE/dist/js/demo.js"></script>-->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->

<script>$(".textarea").wysihtml5();</script>
<script src="/js/parentsController/parents.js"></script>
@endsection
