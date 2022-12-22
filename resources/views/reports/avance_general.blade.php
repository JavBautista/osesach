@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Unidades Económicas: Datos generales
            </div>
            <div class="card-body">


                <hr>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Totales</th>
                                    <th>Inciales</th>
                                    <th>Nuevos</th>
                                    <th>Asignados</th>
                                    <th>Trabajados</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$total_directories}}</td>
                                    <td>{{$iniciales}}</td>
                                    <td>{{$nuevas}}</td>
                                    <td>{{$total_directories_asignadas}} </td>
                                    <td>{{$total_directories_trabajadas}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="alert alert-warning text-center" role="alert">
                  <p>Porcentaje de visiteo</p>
                  @php
                      $porcentaje=number_format(($total_directories_trabajadas*100)/$total_directories , 2 );
                  @endphp
                  <p>{{  $porcentaje  }} %</p>
                </div>

                <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: <?=$porcentaje?>%;" aria-valuenow="<?=$porcentaje?>" aria-valuemin="0" aria-valuemax="100"><?=$porcentaje?>%</div>
                </div>

            </div>
        </div>
    </div>


</div>
@endsection
