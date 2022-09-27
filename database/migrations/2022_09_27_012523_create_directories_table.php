<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directories', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('status_id')->nullable();
            $table->date('fecha_status')->nullable();
            $table->unsignedBigInteger('agent_id')->nullable();
            $table->boolean('asignada')->default(0);
            $table->date('fecha_asignada')->nullable();

            $table->string('id_denue')->nullable();
            $table->string('clee')->nullable();
            $table->string('nombre_unidad')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('codigo_scian')->nullable();
            $table->string('nombre_clase_actividad')->nullable();
            $table->string('descripcion_estrato_personal_ocupado')->nullable();
            $table->string('tipo_vialidad')->nullable();
            $table->string('nombre_vialidad')->nullable();
            $table->string('tipo_entre_vialidad_1')->nullable();
            $table->string('nombre_entre_vialidad_1')->nullable();
            $table->string('tipo_entre_vialidad_2')->nullable();
            $table->string('nombre_entre_vialidad_2')->nullable();
            $table->string('tipo_entre_vialidad_3')->nullable();
            $table->string('nombre_entre_vialidad_3')->nullable();
            $table->string('numero_exterior_o_kilometro')->nullable();
            $table->string('letra_exterior')->nullable();
            $table->string('edificio')->nullable();
            $table->string('edificio_piso')->nullable();
            $table->string('numero_interior')->nullable();
            $table->string('letra_interior')->nullable();
            $table->string('tipo_asentamiento_humano')->nullable();
            $table->string('nombre_asentamiento_humano')->nullable();
            $table->string('tipo_centro_comercial')->nullable();
            $table->string('corredor_industrial_comercial_mercado')->nullable();
            $table->string('numero_local')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->string('clave_entidad')->nullable();
            $table->string('entidad_federativa')->nullable();
            $table->string('clave_municipio')->nullable();
            $table->string('municipio')->nullable();
            $table->string('clave_localidad')->nullable();
            $table->string('localidad')->nullable();
            $table->string('area_geoestadistica')->nullable();
            $table->string('manzana')->nullable();
            $table->string('numero_telefono')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->string('sitio_internet')->nullable();
            $table->string('tipo_establecimiento')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->string('fecha_incorporacion_denue')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directories');
    }
}
