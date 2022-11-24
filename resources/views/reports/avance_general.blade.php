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
                <hr>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>TOTAL</th>
                            <th>Asignados</th>
                            <th>Trabajados</th>
                            <th>Visitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td>{{$total_directories}}</td>
                            <td>{{$total_directories_asignadas}}</td>
                            <td>{{$total_directories_trabajadas}}</td>
                            <td>{{$total_visits}}</td>
                        </tr>
                    </tbody>
                </table>
                <hr>

            </div>
        </div>
    </div>


</div>
@endsection
