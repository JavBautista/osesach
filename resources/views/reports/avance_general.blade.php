@extends('layouts.app')

@section('content')
<div class="container">
    reporte general
    <h2>Total de registros: {{$total_directories}}</h2>
    <h2>Asignadas: {{$total_directories_asignadas}}</h2>
    <h2>Asignadas: {{$total_directories_trabajadas}}</h2>
    <h2>Visitas: {{$total_visits}}</h2>

</div>
@endsection
