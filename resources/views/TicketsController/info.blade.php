@extends('index')

@section('contentbody')
<div class="alert alert-success" id="msg-done" role="alert" style="display: none">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
    <!--<span class="sr-only">Error:</span>-->
    <strong>Caso Editado con Exito</strong>
</div>
<div class="box box-info">
    <div class="box-header">
        <i class="fa fa-ticket"></i>

        <h3 class="box-title">Informacion del caso</h3>
        <!-- tools box -->
        <!-- /. tools -->
    </div>
    <div class="box-body">
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
            <div class="row">
                <div class="col-xs-6">
                    <h4>Comentario del tutor:</h4>
                    <textarea class="textarea" id="comentario_tutor" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                    {{$descripcion}}
                    </textarea>
                </div>
                <input type="hidden" name="idCaso" id="idCaso" value="{{$id}}"  />
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"  />
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
        <button type="button" class="pull-right btn btn-info" id="editar"> Editar </button> 
        <button type="button" class="pull-right btn btn-warning" id="completar"> Completar </button>
    </div>
</div>
@endsection
@section('scriptsjs')
<script>$(".textarea").wysihtml5();</script>
<script src="/js/ticketsController/tickets.js"></script>
@endsection
