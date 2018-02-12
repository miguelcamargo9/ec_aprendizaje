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

    <h3 class="box-title">Informacion del proceso</h3>
    <!-- tools box -->
    <!-- /. tools -->
  </div>
  <div class="box-body" ng-app="app">
    <form action="#" method="post">
      <div class="form-group">
        Cliente <input disabled type="text" class="form-control" value="{{$client_name}}" >
      </div>
      <div class="form-group">
        Fecha Inicial <input id="fecha_ini" type="date" class="form-control" value="{{$fecha_inicio}}" >
      </div>
      <div class="form-group">
        Fecha Final <input id="fecha_fin" type="date" class="form-control" value="{{$fecha_fin}}" >
      </div>
      <div class="row" ng-controller="ticketInfoCtrl">
        <!--                <div class="col-xs-6">
                            <h4>Comentario del tutor:</h4>
                            <textarea class="textarea" id="comentario_tutor" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                            {{$descripcion}}
                            </textarea>
                        </div>-->
        <input type="hidden" name="idCaso" id="idCaso" value="{{$id}}"  />
        <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"  />
        @if($id_estado==5)
        <!--                <div class="col-xs-6">
                            <h4>Respuesta:</h4>
                            <textarea disabled class="textarea" placeholder="Respuesta" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                            </textarea>
                        </div>-->
        @endif
        <!--PINTO TODOS LOS REGISTROS QUE HA HECHO EL USUARIO-->

        @foreach ($registros as $registro)
          @if($registro->aprobado=='N')
            <?php
              $tipoPanel = "panel-warning";
              $estado = "Pendiente por revisar";
            ?>
            @else
            <?php
              $tipoPanel = "panel-success";
              $estado = "Registro revisado";
            ?>
          @endif

        <div class="col-xs-12">
          <div class="panel panel-default {{$tipoPanel}}">
            <div class="panel-heading">Resumen del registro - {{$estado}}</div>
            <div class="panel-body">
              {{$registro->resumen}}
             
            </div>
            <div class="panel-footer">
              <button type="button" class="btn btn-info" ng-click="getDetalesRegistro({{$registro->id}},'{{$registro->resumen}}',{{$registro->total_horas}})" data-toggle="modal" data-target="#detallesRegistro"> Verificar </button> 
            </div>
          </div>
        </div>

        @endforeach
        <!-- FIN PINTO TODOS LOS REGISTROS QUE HA HECHO EL USUARIO-->
         <!-- Modal -->
        <div id="detallesRegistro" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detalles del registro</h4>
              </div>
              <div class="modal-body">
                <div data-ng-repeat="hora in horas track by $index">
                  <p><b>Fecha: </b><% hora.fecha %> <b>Hora inicio: </b><% hora.hora_inicio %> <b>Hora fin:</b> <% hora.hora_fin %></p>
               </div>
                <h3>Total de horas </h3>
                <textarea class="textarea" placeholder="Respuesta" ng-model="resumen"
                          style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
              
                </textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Aprobar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              </div>
            </div>

          </div>
        </div>
      </div>

    </form>
  </div>
  <!--  <div class="box-footer clearfix">
      <button type="button" class="pull-right btn btn-info" id="editar"> Editar </button> 
      <button type="button" class="pull-right btn btn-warning" id="completar"> Completar </button>
    </div>-->
</div>
@endsection
@section('scriptsjs')

<script src="/js/ticketsController/tickets.js"></script>
<script src="//code.angularjs.org/1.2.20/angular-sanitize.min.js"></script>
<script src="/js/ticketsController/ticketsController.js"></script>
<script src="/js/ticketsController/ticketsFactory.js"></script>
<script type="text/javascript" src="/packages/ui-select-master/dist/select.js"></script>
<script>$(".textarea").wysihtml5();</script>
@endsection
