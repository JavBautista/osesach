@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/avance-personal">Avance</a></li>
        <li class="breadcrumb-item"><a href="/avance-personal/persona/{{$persona_id}}">Agente</a></li>
        <li class="breadcrumb-item active" aria-current="page">Visitas</li>
      </ol>
    </nav>

    <div class="row">
        <div class="col">

            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Datos Directorio
                </div>
                <div class="card-body">
                   <h2>{{$directory->nombre_unidad}}</h2>
                   <h3>{{$directory->nombre_vialidad}}</h3>
                   <h3>{{$directory->codigo_postal}}</h3>
                   <hr>
                   <p>{{$directory->codigo_scian}} {{$directory->nombre_clase_actividad}}</p>
                   <hr>
                   <p>{{$directory->numero_telefono }}</p>
                   <p>{{$directory->correo_electronico }}</p>
                   <p>{{$directory->sitio_internet }}</p>
                   <a href="https://www.google.es/maps?q={{$directory->latitud}},{{$directory->longitud}}" target="_blank" class="btn btn-primary"> <i class="bi bi-geo-alt"> </i> Ver en mapa</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">

            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Historial de  Visitas
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th># Visita</th>
                                <th>Estatus</th>
                                <th># Hombres</th>
                                <th># Mujeres</th>
                                <th>Edades</th>
                                <th>Consulta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($visitas as $data)
                            <tr>
                                <td>
                                    <a class="btn btn-warning" href="http://maps.google.com/maps?saddr={{$directory->latitud}},{{$directory->longitud}}&daddr={{$data->latitud}},{{$data->longitud}}" target="_blank" >
                                        <i class="bi bi-geo-alt"> </i> Ver en Checking
                                    </a>
                                </td>
                                <td>{{$data->id}}</td>
                                <td>{{$data->status->description}}</td>
                                <td>{{$data->no_personas_hombres }}</td>
                                <td>{{$data->no_personas_mujeres}}</td>
                                <td>{{$data->rango_edades}}</td>
                                <td>{{$data->consulta}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

</div>
@endsection
