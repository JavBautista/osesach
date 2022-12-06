@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> GENERAL
                <button type="button" class="btn btn-success float-rigth">
                    <i class="bi bi-file-earmark-excel"></i>&nbsp;Exportar
                </button>
            </div>
            <div class="card-body">


                <hr>
                <div class="card">
                    <div class="card-body">
                        <h2>Registros Totales: {{$total_directories}} </h2>
                        <h2>Registros Asignados: {{$total_directories_asignadas}} </h2>
                        <h2>Registros Trabajados: {{$total_directories_trabajadas}} </h2>
                        <h2>Registros Nuevos: {{$nuevas}} </h2>
                    </div>
                </div>

                <div class="alert alert-warning text-center" role="alert">
                  <p>Porcentaje</p>
                  @php
                      $porcentaje=number_format(($total_directories_trabajadas*100)/$total_directories , 2 );
                  @endphp
                  <p>{{  $porcentaje  }}</p>
                </div>

                <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: <?=$porcentaje?>%;" aria-valuenow="<?=$porcentaje?>" aria-valuemin="0" aria-valuemax="100"><?=$porcentaje?>%</div>
                </div>

            </div>
        </div>
    </div>


</div>
@endsection
