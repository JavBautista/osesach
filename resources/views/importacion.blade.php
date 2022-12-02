@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Importacion de Archivo DENUE</div>
                <div class="card-body">
                    <div class="alert alert-info text-center">
                        <i class="bi bi-exclamation-triangle"></i> Verifique que el archivo venga con las columnas en el orden establecido con que se descargo de DENUE
                    </div>
                    <div class="mb-3">
                      <label for="formFile" class="form-label">Seleccione archivo CSV</label>
                      <input class="form-control" type="file" id="formFile">
                    </div>
                    <button class="btn btn-primary"> <i class="bi bi-upload"></i>  Subir  </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection