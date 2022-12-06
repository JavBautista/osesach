@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/avance-personal">Avance</a></li>
    <li class="breadcrumb-item active" aria-current="page">Persona</li>
  </ol>
</nav>
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Avance Personal
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>ID</th>
                        <th>Unidad</th>
                        <th>Direccion</th>
                        <th>Asignada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignacion as $data)
                    <tr>
                        <td><a class="btn btn-primary" href="/avance-personal/visitas?directory_id={{$data->id}}&persona_id={{$persona_id}}"><i class="bi bi-box-arrow-up-right"></i></a></td>
                        <td>{{$data->id}}</td>
                        <td>{{$data->nombre_unidad }}</td>
                        <td>{{$data->nombre_vialidad}}</td>
                        <td>{{$data->fecha_asignada}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
