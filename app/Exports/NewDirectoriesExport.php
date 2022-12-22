<?php

namespace App\Exports;

use App\Models\Directory;
use Illuminate\Support\Facades\DB;
//use Nikazooz\Simplesheet\Concerns\FromCollection;
use Nikazooz\Simplesheet\Concerns\Exportable;
use Nikazooz\Simplesheet\Concerns\FromQuery;
use Nikazooz\Simplesheet\Concerns\WithHeadings;
use Nikazooz\Simplesheet\Concerns\WithMapping;

class NewDirectoriesExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;
    private $buscar,$criterio,$actividad_key,$where_tipo_asentamiento,$where_localidad,$where_incorporacion,$where_tel,$where_email,$where_pagina_web,$where_tam_est;

    public function __construct($buscar,$criterio,$actividad_key,$where_tipo_asentamiento,$where_localidad,$where_incorporacion,$where_tel,$where_email,$where_pagina_web,$where_tam_est)
    {
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

    public function headings(): array
    {
        return [
            'id',
            'id_denue',
            'clee',
            'nombre_unidad',
            'razon_social',
            'codigo_scian',
            'nombre_clase_actividad',
            'descripcion_estrato_personal_ocupado',
            'tipo_vialidad',
            'nombre_vialidad',
            'tipo_entre_vialidad_1',
            'nombre_entre_vialidad_1',
            'tipo_entre_vialidad_2',
            'nombre_entre_vialidad_2',
            'tipo_entre_vialidad_3',
            'nombre_entre_vialidad_3',
            'numero_exterior_o_kilometro',
            'letra_exterior',
            'edificio',
            'edificio_piso',
            'numero_interior',
            'letra_interior',
            'tipo_asentamiento_humano',
            'nombre_asentamiento_humano',
            'tipo_centro_comercial',
            'corredor_industrial_comercial_mercado',
            'numero_local',
            'codigo_postal',
            'clave_entidad',
            'entidad_federativa',
            'clave_municipio',
            'municipio',
            'clave_localidad',
            'localidad',
            'area_geoestadistica',
            'manzana',
            'numero_telefono',
            'correo_electronico',
            'sitio_internet',
            'tipo_establecimiento',
            'latitud',
            'longitud',
            'fecha_incorporacion_denue',
        ];
    }

    public function map($directory): array
    {
        return [
            $directory->id,
            $directory->id_denue,
            $directory->clee,
            $directory->nombre_unidad,
            $directory->razon_social,
            $directory->codigo_scian,
            $directory->nombre_clase_actividad,
            $directory->descripcion_estrato_personal_ocupado,
            $directory->tipo_vialidad,
            $directory->nombre_vialidad,
            $directory->tipo_entre_vialidad_1,
            $directory->nombre_entre_vialidad_1,
            $directory->tipo_entre_vialidad_2,
            $directory->nombre_entre_vialidad_2,
            $directory->tipo_entre_vialidad_3,
            $directory->nombre_entre_vialidad_3,
            $directory->numero_exterior_o_kilometro,
            $directory->letra_exterior,
            $directory->edificio,
            $directory->edificio_piso,
            $directory->numero_interior,
            $directory->letra_interior,
            $directory->tipo_asentamiento_humano,
            $directory->nombre_asentamiento_humano,
            $directory->tipo_centro_comercial,
            $directory->corredor_industrial_comercial_mercado,
            $directory->numero_local,
            $directory->codigo_postal,
            $directory->clave_entidad,
            $directory->entidad_federativa,
            $directory->clave_municipio,
            $directory->municipio,
            $directory->clave_localidad,
            $directory->localidad,
            $directory->area_geoestadistica,
            $directory->manzana,
            $directory->numero_telefono,
            $directory->correo_electronico,
            $directory->sitio_internet,
            $directory->tipo_establecimiento,
            $directory->latitud,
            $directory->longitud,
            $directory->fecha_incorporacion_denue,
        ];
    }

    public function query()
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
            return Directory::query()->where('active',1)
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

                        ->orderBy('id', 'asc');
        }else{
            return Directory::query()->where('active',1)
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
                        ->orderBy('id', 'asc');
        }
        //return Directory::query()->where('fecha_incorporacion_denue','like', $this->incorporacion.'%');
    }
}