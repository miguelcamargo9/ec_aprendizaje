@extends('index')


@section('head')
<title>Lista de Tutores</title>
<meta name="description" content="EC aprendizaje">
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop


@section('contentbody')
<table width="60%" class="table">
    <thead>
        <tr>
            <th>
                LISTA DE TUTORES
            </th>
        </tr>
    </thead>
</table>
<table id="tutors" class="table table-striped table-hover">
    <thead>
        <tr>
            <th>NOMBRE</th>
            <th># IDENTIFICACION</th>
            <th>EMAIL</th>
            <th>CELULAR</th>
            <th>OPCIONES</th>
        </tr>
    </thead>
</table>

@endsection
@section('scriptsjs')

<script src="/js/adminController/tutors.js"></script>
@endsection
