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

@if(isset($documentos) && $documentos=='ok')
  <div class="alert alert-success" id="msg-done" role="alert" >
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <!--<span class="sr-only">Error:</span>-->
    <strong>Documentos guardados</strong>
  </div>
  <script>
    setTimeout(function(){ window.location = "/tutor/tickets/ticketinfo/{{$id}}" }, 2000);
  </script>
@endif
<div class="box box-info" ng-app="app">
  <div class="box-header">
    <i class="fa fa-ticket"></i>

    <h3 class="box-title">Informacion del proceso</h3>
  </div>
  <div class="box-body">
    <div ng-controller="registrosHoras" >
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
      
      <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"  />
      <div class="form-group">
        Cliente <input disabled type="text" class="form-control" value="{{$client_name}}" >
      </div>
      <div class="form-group">
        Fecha Inicial <input disabled id="fecha_ini" type="date" class="form-control" value="{{$fecha_inicio}}" >
      </div>
      
      <!--SECCION PARA AGREGAR COMENTARIOS-->
      <h4>Agregar Documentos</h4>
      <div class="row">
        <form method="post" action="/tutor/guardarDoc" enctype="multipart/form-data">
          <input type="hidden" name="idCaso" value="{{$id}}" ng-model="idCaso"  ng-init="idCaso={{$id}}" ng-value="{{$id}}"  />
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
          <div class="col-xs-3">
            <div class="form-group">
              <input  type="file" name="documentos[]" class="form-control" multiple>
            </div>
          </div>
          <div class="col-xs-2">
            <select name="mes_documento" class="form-control">
              <option value="01">Enero</option>
              <option value="02">Febrero</option>
              <option value="03">Marzo</option>
              <option value="04">Abril</option>
              <option value="05">Mayo</option>
              <option value="06">Junio</option>
              <option value="07">Julio</option>
              <option value="08">Agosto</option>
              <option value="09">Septiembre</option>
              <option value="10">Octubre</option>
              <option value="11">Noviembre</option>
              <option value="12">Diciembre</option>
            </select>
          </div>
          <div class="col-xs-2" >
            <?php
              $anio = date('Y');
            ?>
            <input type="text" name="anio_documento" value="{{$anio}}" class="form-control">

          </div>
          <div class="col-xs-2">
            <button type="submit" class="btn btn-info " > Guardar </button> 
          </div>
        </form>
      </div>
      <!--BOTON PARA AGREGAR UN NUEVO REGISTRO-->
      <div class="row">
        <div class="col-xs-12">
          <button type="button" 
                  class="btn btn-info " 

                  data-toggle="modal" 
                  data-target="#registroHoras"> Agregar registro </button> 
        </div>
      </div>
      <!--FIN BOTON NUEVO REGISTRO-->

      <div class="row">
        <div class="col-xs-12">
          <h4>Total de horas en el proceso: {{$horasRegisro}}</h4>
        </div>
      </div>

      <!--PINTO TODOS LOS REGISTROS QUE HA HECHO EL USUARIO-->
      <div class="row">
 
        @foreach ($registros as $registro)
        @if($registro->aprobado=='N')
        <?php
        $tipoPanel = "panel-warning";
        $estado = "Por verificar";
        $est = 'n';
        ?>
        @else
        <?php
        $tipoPanel = "panel-success";
        $estado = "Verificado";
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
                      ng-click="getDetalesRegistro('{{$registro->id}}','{{$registro->resumen}}','{{$registro->total_horas}}','{{$registro->respuesta_padre}}')" 
                      data-toggle="modal" 
                      data-target="#detallesRegistro"> ver </button> 
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <!-- FIN PINTO TODOS LOS REGISTROS QUE HA HECHO EL TUTOR-->      

      <!--MODAL GUARDAR REGISTRO-->
      <div id="registroHoras" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Registrar horas</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-4"><h4 class="text-center">Fecha</h4></div>
                <div class="col-xs-3">
                  <div class="row">
                    <div class="col-xs-6"><h4 class="text-center">Hora inicio</h4></div>
                    <div class="col-xs-6"><h4 class="text-center">Hora fin</h4></div>
                  </div>
                </div>
              </div>
              <div class="form-group" data-ng-repeat="choice in choices track by $index">
                <label for="choice" ng-show="showChoiceLabel(choice)">Registros</label>
                <div class="row">
                  <div class="col-xs-4">
                    <p class="input-group lostop">
                      <input type="text" class="form-control"  uib-datepicker-popup="<%format%>" ng-model="choice.fecha" 
                             is-open="opened[$index]" datepicker-options="dateOptions" ng-readonly="true" 
                             close-text="Cerrar"
                             ng-required="true" close-text="Close" alt-input-formats="altInputFormats"
                             ng-change="validaFecha(this,choice.fecha)" />

                      <span class="input-group-btn">
                        <button type="button" class="btn btn-default" ng-click="open($event, $index)"><i class="glyphicon glyphicon-calendar"></i></button>
                      </span>
                    </p>
                  </div>
                  <div class="col-xs-3">
                    <div class="row">
                      <div class="col-xs-6">
                        <div uib-timepicker ng-model="choice.hI" ng-change="changed()" readonly-input="true" hour-step="1"  minute-step="30" show-meridian="false"></div>
                      </div>
                      <div class="col-xs-6">
                        <div uib-timepicker ng-model="choice.hF" ng-change="changed()" readonly-input="true" hour-step="1"  minute-step="30" show-meridian="false"></div>
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
                  <textarea   placeholder="Respuesta" ng-model="choices.mensaje"
                              style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">

                  </textarea>
                     <!--<summernote ng-model="choices.mensaje" height="100"></summernote>-->
                </div>
              </div>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" ng-hide="answered" ng-click="saveRegistry()" data-dismiss="modal">Registrar</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
          </div>

        </div>
      </div>
      <!--FIN MODAL GUARDAR REGISTRO-->

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
              <h3>Total de horas: <%totalH%> </h3>
              <textarea  ng-readonly="true" placeholder="Respuesta" ng-model="resumen"
                         style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">

              </textarea>
              <!--comemtario del padre-->
              <div ng-hide="answeredP">
                  <h3>Comentario padre:</h3>
                  <textarea  ng-readonly="true"  ng-model="comPadre"
                             style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">

                  </textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
          </div>

        </div>
      </div>
      <!--FIN MODAL INFORMACION DEL REGISTRO -->
    </div>

  </div>

</div>
@endsection
@section('scriptsjs')
<script src="/js/tutorsController/tutors.js"></script>
<script src="/packages/ui-bootstrap/ui-bootstrap-tpls-2.5.0.min.js"></script>
<script src="/js/tutorsController/tutorsController.js"></script>
<script src="/js/tutorsController/tutorsFactory.js"></script>


@endsection
