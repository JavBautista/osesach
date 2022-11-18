<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEdadesAndNumPersonasToVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->string('no_personas_hombres')->nullable();
            $table->string('no_personas_mujeres')->nullable();
            $table->string('rango_edades')->nullable();
            $table->string('consulta')->nullable();
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn('no_personas_hombres');
            $table->dropColumn('no_personas_mujeres');
            $table->dropColumn('rango_edades');
            $table->dropColumn('consulta');
            $table->dropColumn('latitud');
            $table->dropColumn('longitud');
        });
    }
}
