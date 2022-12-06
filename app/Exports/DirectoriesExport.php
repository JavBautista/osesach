<?php
namespace App\Exports;

use App\Models\Directory;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DirectoriesExport implements FromView
{
    private $buscar,$criterio,$actividad_key,$where_tipo_asentamiento,$where_localidad,$where_incorporacion,$where_tel,$where_email,$where_pagina_web,$where_tam_est;

    function __construct($buscar,$criterio,$actividad_key,$where_tipo_asentamiento,$where_localidad,$where_incorporacion,$where_tel,$where_email,$where_pagina_web,$where_tam_est) {
        $this->buscar=$buscar;
        $this->criterio=$criterio;
        $this->actividad_key=$actividad_key;
        $this->where_tipo_asentamiento=$where_tipo_asentamiento;
        $this->where_localidad=$where_localidad;
        $this->where_incorporacion=$where_incorporacion;
        $this->where_tel=$where_tel;
        $this->where_email=$where_email;
        $this->where_pagina_web=$where_pagina_web;
        $this->where_tam_est=$where_tam_est;


    }

    public function view(): View
    {
        $buscar = $this->buscar;
        $criterio = $this->criterio;
        $actividad_key = $this->actividad_key;
        $where_tipo_asentamiento = $this->where_tipo_asentamiento;
        $where_localidad = $this->where_localidad;
        $where_incorporacion = $this->where_incorporacion;
        $where_tel = $this->where_tel;
        $where_email = $this->where_email;
        $where_pagina_web = $this->where_pagina_web;
        $where_tam_est = $this->where_tam_est;


        if($buscar==''){
            $directories = Directory::where('active',1)
                        ->when($actividad_key, function ($query, $actividad_key) {
                            return $query->where('codigo_scian', '=', $actividad_key);
                        })
                        ->when($where_tam_est, function ($query, $where_tam_est) {
                            return $query->where('descripcion_estrato_personal_ocupado','like', $where_tam_est);
                        })
                        ->when($where_tipo_asentamiento, function ($query, $where_tipo_asentamiento) {
                            return $query->where('tipo_asentamiento_humano','like', $where_tipo_asentamiento);
                        })
                        ->when($where_localidad, function ($query, $where_localidad) {
                            return $query->where('localidad','like', $where_localidad);
                        })
                        ->when($where_incorporacion, function ($query, $where_incorporacion) {
                            return $query->where('fecha_incorporacion_denue','like', $where_incorporacion.'%');
                        })

                        ->when( ($where_tel == 'sin' ), function ($query) {
                            return $query->whereNull('numero_telefono')
                                         ->orWhere('numero_telefono','like', '');
                        })
                        ->when( ($where_tel == 'con' ), function ($query) {
                            return $query->where('numero_telefono','not like', '');
                        })

                        ->when( ($where_email == 'sin' ), function ($query) {
                            return $query->whereNull('correo_electronico')
                                         ->orWhere('correo_electronico','like', '');
                        })
                        ->when( ($where_email == 'con' ), function ($query) {
                            return $query->where('correo_electronico','not like', '');
                        })

                        ->when( ($where_pagina_web == 'sin' ), function ($query) {
                            return $query->whereNull('sitio_internet')
                                         ->orWhere('sitio_internet','like', '');
                        })
                        ->when( ($where_pagina_web == 'con' ), function ($query) {
                            return $query->where('sitio_internet','not like', '');
                        })

                        ->orderBy('id', 'asc')
                        ->get();
        }else{
            $directories = Directory::where('active',1)
                        ->where($criterio, 'like', '%'.$buscar.'%')
                        ->when($actividad_key, function ($query, $actividad_key) {
                            return $query->where('codigo_scian', '=', $actividad_key);
                        })
                        ->when($where_tam_est, function ($query, $where_tam_est) {
                            return $query->where('descripcion_estrato_personal_ocupado','like', $where_tam_est);
                        })
                        ->when($where_tipo_asentamiento, function ($query, $where_tipo_asentamiento) {
                            return $query->where('tipo_asentamiento_humano','like', $where_tipo_asentamiento);
                        })
                        ->when($where_localidad, function ($query, $where_localidad) {
                            return $query->where('localidad','like', $where_localidad);
                        })
                        ->when($where_incorporacion, function ($query, $where_incorporacion) {
                            return $query->where('fecha_incorporacion_denue','like', $where_incorporacion.'%');
                        })
                        ->orderBy('id', 'asc')
                        ->get();
        }


        return view('exports.directories', [
            'directories' => $directories
        ]);
    }
}