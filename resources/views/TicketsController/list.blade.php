@extends('index')


@section('head')
    <title>Asignacion de casos</title>
    <meta name="description" content="EC aprendizaje">
    <meta http-equiv="refresh" content="60">
    <link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
    <link href="/packages/bootstrap/css/popbox.css" media="screen" charset="utf-8" rel="stylesheet">
@stop


@section('contentbody')
    <?php
    $visible = (isset($mensaje) && $mensaje != '') ? "display:block;" : "display:none;";
    ?>
    <div id="msg-done" class="alert alert-success" role="alert" style="{{$visible}}">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only"></span>
        <strong id="msj">{{$mensaje}}</strong>
    </div>
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}"  />
    <table width="60%" class="table">
        <thead>
        <tr>
            <th>
                LISTA DE PROCESOS
            </th>
        </tr>
        </thead>
    </table>
    <form id="frm-example" action="/tickets/updatestate" method="POST">
        <table id="tickets" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ESTADO</th>
                <th>ESTUDIANTE</th>
                <th>FECHA DE INICIO</th>
                <th>OPCIONES</th>
            </tr>
            </thead>
        </table>

<!--        <button type="submit" class="pull-left btn btn-default" id="accept">Asignar
            <i class="fa fa-check-square"></i></button>-->
        <pre hidden id="example-console"></pre>
    </form>

@endsection
@section('scriptsjs')

    <script src="/js/ticketsController/tickets.js"></script>
@endsection
