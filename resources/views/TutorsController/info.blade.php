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
      <input type="hidden" name="idCaso" id="idCaso" value="{{$id}}"  />
      <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"  />
      <div class="form-group">
        Cliente <input disabled type="text" class="form-control" value="{{$client_name}}" >
      </div>
      <div class="form-group">
          Fecha Inicial <input disabled id="fecha_ini" type="date" class="form-control" value="{{$fecha_inicio}}" >
      </div>
      <div class="row">
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
      </div>
    </form>
  </div>
  <div class="box-footer clearfix">
    <button type="button" class="btn btn-default" id="editar">Enviar</button>
  </div>
</div>
@endsection
@section('scriptsjs')
<!-- AdminLTE for demo purposes -->
{{--<script src="/packages/adminLTE/dist/js/demo.js"></script>--}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script>$(".textarea").wysihtml5();</script>
<script src="/js/tutorsController/tutors.js"></script>
@endsection
