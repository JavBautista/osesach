<table class="table table-bordered table-striped table-sm">
    <thead>
        <tr>
            <th>id</th>
            <th>#id_denue</th>
            <th>clee</th>
            <th>nombre_unidad</th>
            <th>razon_social</th>
            <th>codigo_scian</th>
            <th>nombre_clase_actividad</th>
            <th>descripcion_estrato_personal_ocupado</th>
            <th>tipo_vialidad</th>
            <th>nombre_vialidad</th>
            <th>tipo_entre_vialidad_1</th>
            <th>nombre_entre_vialidad_1</th>
            <th>tipo_entre_vialidad_2</th>
            <th>nombre_entre_vialidad_2</th>
            <th>tipo_entre_vialidad_3</th>
            <th>nombre_entre_vialidad_3</th>
            <th>numero_exterior_o_kilometro</th>
            <th>letra_exterior</th>
            <th>edificio</th>
            <th>edificio_piso</th>
            <th>numero_interior</th>
            <th>letra_interior</th>
            <th>tipo_asentamiento_humano</th>
            <th>nombre_asentamiento_humano</th>
            <th>tipo_centro_comercial</th>
            <th>corredor_industrial_comercial_mercado</th>
            <th>numero_local</th>
            <th>codigo_postal</th>
            <th>clave_entidad</th>
            <th>entidad_federativa</th>
            <th>clave_municipio</th>
            <th>municipio</th>
            <th>clave_localidad</th>
            <th>localidad</th>
            <th>area_geoestadistica</th>
            <th>manzana</th>
            <th>numero_telefono</th>
            <th>correo_electronico</th>
            <th>sitio_internet</th>
            <th>tipo_establecimiento</th>
            <th>latitud</th>
            <th>longitud</th>
            <th>fecha_incorporacion_denue</th>
        </tr>
    </thead>
    <tbody>
      @foreach($directories as $directory)
        <tr>
            <td>{{ $directory->id }}</td>
            <td>{{ $directory->id_denue }}</td>
            <td>{{ $directory->clee }}</td>
            <td>{{ $directory->nombre_unidad }}</td>
            <td>{{ $directory->razon_social }}</td>
            <td>{{ $directory->codigo_scian }}</td>
            <td>{{ $directory->nombre_clase_actividad }}</td>
            <td>{{ $directory->descripcion_estrato_personal_ocupado }}</td>
            <td>{{ $directory->tipo_vialidad }}</td>
            <td>{{ $directory->nombre_vialidad }}</td>
            <td>{{ $directory->tipo_entre_vialidad_1 }}</td>
            <td>{{ $directory->nombre_entre_vialidad_1 }}</td>
            <td>{{ $directory->tipo_entre_vialidad_2 }}</td>
            <td>{{ $directory->nombre_entre_vialidad_2 }}</td>
            <td>{{ $directory->tipo_entre_vialidad_3 }}</td>
            <td>{{ $directory->nombre_entre_vialidad_3 }}</td>
            <td>{{ $directory->numero_exterior_o_kilometro }}</td>
            <td>{{ $directory->letra_exterior }}</td>
            <td>{{ $directory->edificio }}</td>
            <td>{{ $directory->edificio_piso }}</td>
            <td>{{ $directory->numero_interior }}</td>
            <td>{{ $directory->letra_interior }}</td>
            <td>{{ $directory->tipo_asentamiento_humano }}</td>
            <td>{{ $directory->nombre_asentamiento_humano }}</td>
            <td>{{ $directory->tipo_centro_comercial }}</td>
            <td>{{ $directory->corredor_industrial_comercial_mercado }}</td>
            <td>{{ $directory->numero_local }}</td>
            <td>{{ $directory->codigo_postal }}</td>
            <td>{{ $directory->clave_entidad }}</td>
            <td>{{ $directory->entidad_federativa }}</td>
            <td>{{ $directory->clave_municipio }}</td>
            <td>{{ $directory->municipio }}</td>
            <td>{{ $directory->clave_localidad }}</td>
            <td>{{ $directory->localidad }}</td>
            <td>{{ $directory->area_geoestadistica }}</td>
            <td>{{ $directory->manzana }}</td>
            <td>{{ $directory->numero_telefono }}</td>
            <td>{{ $directory->correo_electronico }}</td>
            <td>{{ $directory->sitio_internet }}</td>
            <td>{{ $directory->tipo_establecimiento }}</td>
            <td>{{ $directory->latitud }}</td>
            <td>{{ $directory->longitud }}</td>
            <td>{{ $directory->fecha_incorporacion_denue }}</td>
        </tr>
      @endforeach
    </tbody>
</table>