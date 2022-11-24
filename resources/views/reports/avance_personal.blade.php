@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <i class="fa fa-align-justify"></i> Actividades
            <button type="button" class="btn btn-success float-rigth">
                <i class="bi bi-file-earmark-excel"></i>&nbsp;Exportar
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Agente</th>
                        <th>Asigando</th>
                        <th>Trabajado</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($personal as $persona)
                    <tr>

                        <td>{{$persona['persona_id']}}</td>
                        <td>{{$persona['persona_nombre']}}</td>
                        <td>{{$persona['asignado']}}</td>
                        <td>{{$persona['trabajado']}}</td>
                        <td>{{$persona['porcentaje']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
