@extends('index')

@section('contentbody')

<div class="alert alert-success" id="msg-done" role="alert" style="display: none">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <!--<span class="sr-only">Error:</span>-->
  <strong>Caso Editado con Exito</strong>
</div>
<div class="box box-info" ng-app="app">
  <div class="box-header">
    <i class="fa fa-ticket"></i>

    <h3 class="box-title">Información del proceso</h3>
    <!-- tools box -->
    <!-- /. tools -->
  </div>
  <div class="box-body" ng-controller="ticketInfoCtrl">
    <!--mensaje de error-->
    <div ng-repeat="errorObj in error.msjs">
      <div class="alert alert-danger" role="alert" ng-repeat="msj in errorObj">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        <strong><%msj%></strong>
      </div>
    </div>
    <!--mensaje de exito-->
    <div class="alert alert-success" role="alert" ng-show="success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
      <span class="sr-only">Éxito:</span>
      <strong><%success%></strong>
    </div>

    <form action="#" method="post">
      <div class="form-group">
        Cliente <input disabled type="text" class="form-control" value="{{$client_name}}" >
      </div>
      <div class="form-group">
        Fecha Inicial <input id="fecha_ini" type="date" class="form-control" value="{{$fecha_inicio}}" readonly>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <h4>Total de horas en el proceso: {{$horasRegisro}}</h4>
        </div>
      </div>
      <div class="row" >

        <input type="hidden"  ng-model="idCaso"  ng-init="idCaso={{$id}}" ng-value="{{$id}}"  />
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"  />


        @foreach ($registros as $registro)
        @if($registro->aprobado=='N')
        <?php
        $tipoPanel = "panel-warning";
        $estado = "Por verificar";
        $txtBtn = "Verificar";
        $est = 'n';
        ?>
        @else
        <?php
        $tipoPanel = "panel-success";
        $estado = "Verificado";
        $txtBtn = "Ver";
        $est = 's';
        ?>
        @endif

        <div class="col-xs-12">
          <div class="panel panel-default {{$tipoPanel}}">
            <div class="panel-heading">Resumen del registro - {{$estado}} <b>Fecha:</b> {{date("Y-m-d",strtotime($registro->fecha_creacion))}}</div>
            <div class="panel-body">
              {{$registro->resumen}}
            </div>
            <div class="panel-footer">
              <button type="button" 
                      class="btn btn-info" 
                      ng-click="getDetalesRegistro({{$registro->id}},'{{$registro->resumen}}',{{$registro->total_horas}},'{{$est}}','{{$registro->respuesta_padre}}')" 
                      data-toggle="modal" 
                      data-target="#detallesRegistro"> {{$txtBtn}} </button> 
            </div>
          </div>
        </div>

        @endforeach
        <!-- FIN PINTO TODOS LOS REGISTROS QUE HA HECHO EL TUTOR-->

        <!-- MODAL INFORMACION DEL REGISTRO -->
        <div id="detallesRegistro" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detalles del registro</h4>
              </div>
              <div class="modal-body">
                <div data-ng-repeat="hora in horas">
                  <p><b>Fecha: </b><% hora.fecha %> <b>Hora inicio: </b><% hora.hora_inicio %> <b>Hora fin:</b> <% hora.hora_fin %></p>
                </div>
                <label>Documento adjunto: </label>
                <a href="<%enlace%>" target="_blank"><%nombreEnlace%></a>
                <h3>Total de horas: <%totalH%> </h3>
                <div>
                  <h3>Comentario tutor:</h3>
                  <textarea  ng-readonly="answered" placeholder="Respuesta" ng-model="resumen"
                             style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">

                  </textarea>
                </div>
                
                <div ng-hide="answeredP">
                  <h3>Comentario padre:</h3>
                  <textarea  ng-readonly="answered" placeholder="Respuesta" ng-model="comPadre"
                             style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">

                  </textarea>
                </div>
               <!--<summernote ng-readonly="answered" placeholder="Respuesta" ng-model="resumen"></summernote>-->
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" ng-hide="answered" ng-click="aprobarRegistro()" data-dismiss="modal">Aprobar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              </div>
            </div>

          </div>
        </div>
        <!--FIN MODAL INFORMACION DEL REGISTRO -->
      </div>

    </form>
  </div>
</div>
@endsection
@section('scriptsjs')

<script src="/js/ticketsController/tickets.js"></script>
<script src="/packages/ui-bootstrap/ui-bootstrap-tpls-2.5.0.min.js"></script>
<script src="//code.angularjs.org/1.2.20/angular-sanitize.min.js"></script>
<script src="/js/ticketsController/ticketsController.js"></script>
<script src="/js/ticketsController/ticketsFactory.js"></script>
<script type="text/javascript" src="/packages/ui-select-master/dist/select.js"></script>
@endsection
