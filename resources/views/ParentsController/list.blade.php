@extends('index')


@section('head')
<title>Listado de Procesos</title>
<meta name="description" content="EC aprendizaje">
<link href="/packages/bootstrap/css/loading.css" rel="stylesheet">
<link href="/packages/bootstrap/css/popbox.css" media="screen" charset="utf-8" rel="stylesheet">
@stop


@section('contentbody')
<?php
$visible = (isset($mensaje) && $mensaje != '') ? "display:block;" : "display:none;";
?>
<div class="alert alert-success" role="alert" style="{{$visible}}">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
  @if(isset($mensaje))
  <strong>{{$mensaje}}</strong>
  @endif
</div>

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
        <th>VER</th>
      </tr>
    </thead>
  </table>
  <pre hidden id="example-console"></pre>
</form>

@endsection
@section('scriptsjs')

<script src="/js/parentsController/parents.js"></script>
@endsection
