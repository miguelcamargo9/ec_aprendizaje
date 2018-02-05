@extends('index')

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
  .lostop{
    margin-top: 34px;
  }
</style>
@section('contentbody')
<div class="alert alert-success" id="msg-done" role="alert" style="display: none">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <!--<span class="sr-only">Error:</span>-->
  <strong>Comentario guardado</strong>
</div>
<div class="box box-info" ng-app="app">
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
    <div ng-controller="registrosHoras" class="container">
      <input type="hidden"  ng-model="idCaso"  ng-init="idCaso={{$id}}" ng-value="{{$id}}"  />
      <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"  />
      <div class="form-group">
        Cliente <input disabled type="text" class="form-control" value="{{$client_name}}" >
      </div>
      <div class="form-group">
        Fecha Inicial <input disabled id="fecha_ini" type="date" class="form-control" value="{{$fecha_inicio}}" >
      </div>
      <!--      <div class="row">
              <div class="col-xs-6">
                <h4>Comentario del tutor:</h4>
                <textarea id="comentario" class="textarea" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                  {{$descripcion}}
                </textarea>
              </div>
              @if($id_estado==5)
                <div class="col-xs-6">
                  <h4>Respuesta:</h4>
                  <textarea disabled class="textarea" placeholder="Respuesta" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                  </textarea>
                </div>
              @endif
            </div>-->




      <div class="form-group" data-ng-repeat="choice in choices track by $index">

        <label for="choice" ng-show="showChoiceLabel(choice)">Registros</label>
        <div class="row">
          <div class="col-xs-4">

            <p class="input-group lostop">
              <input type="text" class="form-control"  uib-datepicker-popup="<%format%>" ng-model="choice.fecha" 
                     is-open="opened[$index]" datepicker-options="dateOptions" ng-readonly="true" 
                     close-text="Cerrar"
                     ng-required="true" close-text="Close" alt-input-formats="altInputFormats" />

              <span class="input-group-btn">
                <button type="button" class="btn btn-default" ng-click="open($event, $index)"><i class="glyphicon glyphicon-calendar"></i></button>
              </span>
            </p>
          </div>
          <div class="col-xs-3">
            <div class="row">
              <div class="col-xs-6">
                <div uib-timepicker ng-model="choice.hI" ng-change="changed()" readonly-input="true" hour-step="1"  minute-step="15" show-meridian="false"></div>
              </div>
              <div class="col-xs-6">
                <div uib-timepicker ng-model="choice.hF" ng-change="changed()" readonly-input="true" hour-step="1"  minute-step="15" show-meridian="false"></div>
              </div>
            </div>
          </div>
          <div class="col-xs-4 lostop">
            <button type="button" class="btn btn-default btn-sm"  ng-show="showAddChoice(choice)" ng-click="addNewChoice()">
              <span class="glyphicon glyphicon-plus"></span> Agregar
            </button>
            <button type="button" class="btn btn-default btn-sm" ng-click="removeNewChoice()">
              <span class="glyphicon glyphicon-minus"></span> Borrar
            </button>
<!--              <i class="fas fa-plus" aria-hidden='true' ng-show="showAddChoice(choice)" ng-click="addNewChoice()"></i>
            <i class="fas fa-minus-circle" ng-click="removeNewChoice()"></i>-->
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-xs-12">
          <h3>Total de horas registrdas <%choices.totalHoras%></h3>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <textarea  
            placeholder="Cometario" 
            style="width: 90%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" 
            ng-model="choices.mensaje" ></textarea>
        </div>
      </div>


      <div class="box-footer clearfix">
        <button type="button" ng-click="saveRegistry()" class="btn btn-default" >Enviar</button>
      </div>
    </div>

  </div>

</div>
@endsection
@section('scriptsjs')
<!-- AdminLTE for demo purposes -->
{{-- < script src = "/packages/adminLTE/dist/js/demo.js" > < /script>--}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script>$(".textarea").wysihtml5();</script>
<script src="/js/tutorsController/tutors.js"></script>
<script src="/js/libs/ui-bootstrap/ui-bootstrap-tpls-2.5.0.min.js"></script>
<script src="/js/tutorsController/tutorsController.js"></script>
<script src="/js/tutorsController/tutorsFactory.js"></script>


@endsection
