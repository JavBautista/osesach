<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Directory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

use App\Exports\DirectoriesExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\NewDirectoriesExport;
use Nikazooz\Simplesheet\Facades\Simplesheet;

class DirectoryController extends Controller
{
    public function index(Request $request)
    {

        $suppliers = Directory::where('active',1)
                    ->orderBy('id','desc')
                    ->paginate(5);

        return $suppliers;

    }

    public function buscar(Request $request)
    {

        $buscar = $request->buscar;
        $directories = Directory::where('active',1)
                    ->where('nombre_unidad', 'like', "%$buscar%")
                    ->orderBy('id','desc')
                    ->get();

        return response()->json([
            'ok'=>true,
            'data' => $directories,
        ]);

    }

    public function getApiDirectoriesAgent(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $visitados   =   isset($request->visitados)?$request->visitados:0;
        $agente_id   =   $request->agente_id;

        $cond_visitados= ($visitados)?'<>':'=';

        $buscar = $request->buscar;
        if($buscar==''){
            $directories = Directory::where('active',1)
                    ->where('agent_id',$agente_id)
                    ->where('asignada',1)
                    ->where('status_id',$cond_visitados,0)
                    ->orderBy('codigo_postal','ASC')
                    ->orderBy('nombre_vialidad','ASC')
                    ->paginate(50);
        }else{
            $directories = Directory::where('active',1)
                    ->where('agent_id',$agente_id)
                    ->where('asignada',1)
                    ->where('status_id',$cond_visitados,0)
                    ->where('nombre_unidad', 'like', '%'.$buscar.'%')
                    ->orderBy('codigo_postal','ASC')
                    ->orderBy('nombre_vialidad','ASC')
                    ->paginate(50);
        }
        return $directories;
    }//.getDirectoriesAgent()

    public function getApiResumenAgent(Request $request)
    {
        $agente_id   =   $request->agente_id;
        $asignadas=0;
        $trabajadas=0;
        $faltantes=0;
        $porcentaje_avance=0;
        $value_progress_bar=0;

        $asignadas =    DB::table('directories')->where('asignada',1)->where('agent_id',$agente_id)->count();
        if($asignadas){

            $trabajadas =   DB::table('directories')
                            ->where('asignada',1)
                            ->where('agent_id',$agente_id)
                            ->where('status_id','>',0)
                            ->count();

            $faltantes =   DB::table('directories')
                            ->where('asignada',1)
                            ->where('agent_id',$agente_id)
                            ->where('status_id','=',0)
                            ->count();

            $porcentaje_avance= ($trabajadas*100/$asignadas);
            $porcentaje_avance=number_format($porcentaje_avance,2);
            $value_progress_bar=$porcentaje_avance/100;
            $value_progress_bar=number_format($value_progress_bar,2);

        }
        return response()->json([
            'ok'=>true,
            'asignadas' => $asignadas,
            'trabajadas' => $trabajadas,
            'faltantes' => $faltantes,
            'porcentaje_avance' => $porcentaje_avance,
            'value_progress_bar' => $value_progress_bar,
        ]);
    }//.getApiResumenAgent()

    public function getApiResumenGeneral(Request $request)
    {

        $totales=0;
        $asignadas=0;
        $trabajadas=0;
        $faltantes=0;
        $porcentaje_avance=0;
        $value_progress_bar=0;

        $totales    = DB::table('directories')->count();
        $asignadas  = DB::table('directories')->where('asignada',1)->count();
        $nuevas     = DB::table('directories')->whereNull('id_denue')->count();
        $trabajadas = DB::table('directories')->where('status_id','>',0)->count();
        $faltantes  = DB::table('directories')->where('status_id','=',0)->count();

        if($totales){
            $porcentaje_avance= ($trabajadas*100/$totales);
            $porcentaje_avance=number_format($porcentaje_avance,2);
            $value_progress_bar=$porcentaje_avance/100;
            $value_progress_bar=number_format($value_progress_bar,2);

        }
        return response()->json([
            'ok'=>true,
            'nuevas' => $nuevas,
            'totales' => $totales,
            'asignadas' => $asignadas,
            'trabajadas' => $trabajadas,
            'faltantes' => $faltantes,
            'porcentaje_avance' => $porcentaje_avance,
            'value_progress_bar' => $value_progress_bar,
        ]);
    }//.getApiResumenGeneral()


    public function asignacion(Request $request)
    {
        return view('asignacion');
    }

    public function asignar($persona_id)
    {

        return view('asignar',['persona_id'=>$persona_id]);
    }



    public function getDirectoriesForAssign(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar   =   $request->buscar;
        $criterio = $request->criterio;
        $num_registros = $request->num_registros;

        $actividad_key = $request->actividad_key;

        $filtro_tipo_asentamiento=$request->filtro_tipo_asentamiento;
        $where_tipo_asentamiento=($filtro_tipo_asentamiento=='TODOS')?null:$filtro_tipo_asentamiento;

        $filtro_localidad = $request->filtro_localidad;
        $where_localidad=($filtro_localidad=='TODOS')?null:$filtro_localidad;

        $filtro_nombre_asentamiento = $request->filtro_nombre_asentamiento;
        $where_nombre_asentamiento=($filtro_nombre_asentamiento=='TODOS')?null:$filtro_nombre_asentamiento;

        $filtro_incorporacion = $request->filtro_incorporacion;
        $where_incorporacion=($filtro_incorporacion=='TODOS')?null:$filtro_incorporacion;
        //dd($where_tipo_asentamiento);

        $filtro_tam_est = $request->filtro_tam_est;

        $filtro_telefono=$request->filtro_telefono;
        $where_tel=($filtro_telefono=='TODOS')?null:$filtro_telefono;

        $filtro_email=$request->filtro_email;
        $where_email=($filtro_email=='TODOS')?null:$filtro_email;

        $filtro_pagina_web=$request->filtro_pagina_web;
        $where_pagina_web=($filtro_pagina_web=='TODOS')?null:$filtro_pagina_web;


        $where_tam_est=null;
        switch ($filtro_tam_est) {
            case 1: $where_tam_est='0 a 5 personas'; break;
            case 2: $where_tam_est='6 a 10 personas'; break;
            case 3: $where_tam_est='11 a 30 personas'; break;
            case 4: $where_tam_est='31 a 50 personas'; break;
            case 5: $where_tam_est='51 a 100 personas'; break;
            case 6: $where_tam_est='101 a 250 personas'; break;
            case 7: $where_tam_est='251 y más personas'; break;
        }

        if($buscar==''){
            $directories = Directory::where('active',1)
                        ->where('asignada',0)
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
                        ->when($where_nombre_asentamiento, function ($query, $where_nombre_asentamiento) {
                            return $query->where('nombre_asentamiento_humano','like', $where_nombre_asentamiento);
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
                        ->orderBy('id','desc')
                        ->limit($num_registros)
                        ->paginate(20);
        }else{

            $directories = Directory::where('active',1)
                        ->where('asignada',0)
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
                        ->when($where_nombre_asentamiento, function ($query, $where_nombre_asentamiento) {
                            return $query->where('nombre_asentamiento_humano','like', $where_nombre_asentamiento);
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
                        ->orderBy('id','desc')
                        ->limit($num_registros)
                        ->paginate(20);
        }

        return [
            'pagination'=>[
                'total'=> $directories->total(),
                'current_page'=> $directories->currentPage(),
                'per_page'=> $directories->perPage(),
                'last_page'=> $directories->lastPage(),
                'from'=> $directories->firstItem(),
                'to'=> $directories->lastItem(),
            ],
            'directories'=>$directories,
        ];
    }//.getDirectoriesForAssign()

    public function getDirectoriesAgent(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $agente_id   =   $request->agente_id;
        $buscar      =   $request->buscar;
        $criterio    = $request->criterio;
        $num_registros = $request->num_registros;
        if($buscar==''){
            $directories = Directory::where('active',1)
                        ->where('agent_id',$agente_id)
                        ->where('asignada',1)
                        ->orderBy('id','desc')
                        ->limit($num_registros)
                        ->get();
        }else{

            $directories = Directory::where('active',1)
                        ->where('agent_id',$agente_id)
                        ->where('asignada',1)
                        ->where($criterio, 'like', '%'.$buscar.'%')
                        ->orderBy('id','desc')
                        ->limit($num_registros)
                        ->get();
        }

        return $directories;
    }//.getDirectoriesAgent()

    public function asignarRegistrosAgente(Request $request){
        $agente_id   = $request->agente_id;
        $buscar      = $request->buscar;
        $criterio    = $request->criterio;
        $num_registros = $request->num_registros;

        $now = Carbon::now();

        if($buscar==''){
            Directory::where('active',1)
                ->where('asignada',0)
                ->orderBy('id','desc')
                ->limit($num_registros)
                ->update([
                    'asignada' => 1,
                    'agent_id' => $agente_id,
                    'fecha_asignada' => $now,
                    ]);

        }else{
            Directory::where('active',1)
                    ->where('asignada',0)
                    ->where($criterio, 'like', '%'.$buscar.'%')
                    ->orderBy('id','desc')
                    ->limit($num_registros)
                    ->update([
                        'asignada' => 1,
                        'agent_id' => $agente_id,
                        'fecha_asignada' => $now,
                        ]);
        }
    }//.asignarRegistrosAgente()

    public function desasignarRegistrosAgente(Request $request){
        $agente_id   =   $request->agente_id;
        Directory::where('asignada',1)
                ->where('agent_id',$agente_id)
                ->update([
                    'asignada' => 0,
                    'agent_id' => 0,
                    'fecha_asignada' => null,
                    ]);
    }//.desasignarRegistrosAgente()


    public function asignarPorRegistroAgente(Request $request){
        $now = Carbon::now();
        $agente_id    = $request->agente_id;
        $directory_id = $request->directory_id;

        $directory=Directory::findOrFail($directory_id);
        $directory->asignada=1;
        $directory->agent_id=$agente_id;
        $directory->fecha_asignada=$now;
        $directory->save();
    }//.asignarPoRegistroAgente()

    public function desasignarPorRegistroAgente(Request $request){
        $directory_id = $request->directory_id;
        $directory=Directory::findOrFail($directory_id);
        $directory->asignada=0;
        $directory->agent_id=0;
        $directory->fecha_asignada=null;
        $directory->save();
    }//.desasignarPorRegistroAgente()


    public function store(Request $request){

        $dir = $request->directory;
        $person_id= $request->person_id;

        //$directory= Directory::findOrFail(1);
        $directory =new Directory();
        $directory->nombre_unidad           = $dir['nombre_unidad'];
        $directory->codigo_scian            = $dir['codigo_scian'];
        $directory->nombre_clase_actividad  = $dir['nombre_clase_actividad'];
        $directory->nombre_vialidad         = $dir['nombre_vialidad'];
        $directory->codigo_postal           = $dir['codigo_postal'];
        $directory->numero_telefono         = $dir['numero_telefono'];
        $directory->correo_electronico      = $dir['correo_electronico'];
        $directory->sitio_internet          = $dir['sitio_internet'];
        $directory->latitud                 = $dir['latitud'];
        $directory->longitud                = $dir['longitud'];
        $directory->numero_exterior_o_kilometro = $dir['numero_exterior_o_kilometro'];
        $directory->nombre_asentamiento_humano  = $dir['nombre_asentamiento_humano'];
        $directory->descripcion_estrato_personal_ocupado= $dir['descripcion_estrato_personal_ocupado'];


        $directory->status_id = 0;
        $directory->agent_id  = $person_id;
        $directory->asignada  = 1;

        $directory->tipo_vialidad = 'CALLE';
        $directory->tipo_asentamiento_humano='COLONIA';
        $directory->clave_entidad='21';
        $directory->entidad_federativa='PUEBLA';
        $directory->clave_municipio='19';
        $directory->municipio='San Andrés Cholula';
        $directory->clave_localidad='1';
        $directory->localidad='San Andrés Cholula';

        $directory->save();

        return response()->json([
            'ok'=>true,
            'directory' => $directory,
        ]);
    }

    public function update(Request $request){
        $directory= Directory::findOrFail($request->id);
        $directory->nombre_vialidad=$request->nombre_vialidad;
        $directory->numero_exterior_o_kilometro=$request->numero_exterior_o_kilometro;
        $directory->nombre_asentamiento_humano=$request->nombre_asentamiento_humano;
        $directory->codigo_postal=$request->codigo_postal;
        $directory->numero_telefono=$request->numero_telefono;
        $directory->correo_electronico=$request->correo_electronico;
        $directory->sitio_internet=$request->sitio_internet;
        $directory->save();
        return response()->json([
            'ok'=>true,
            'directory' => $directory,
        ]);
    }

    public function inicio(){
        return view('directory');
    }//.inicio()

    public function get(Request $request)
    {
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $actividad_key = $request->actividad_key;

        $filtro_tipo_asentamiento=$request->filtro_tipo_asentamiento;
        $where_tipo_asentamiento=($filtro_tipo_asentamiento=='TODOS')?null:$filtro_tipo_asentamiento;

        $filtro_localidad = $request->filtro_localidad;
        $where_localidad=($filtro_localidad=='TODOS')?null:$filtro_localidad;

        $filtro_nombre_asentamiento = $request->filtro_nombre_asentamiento;
        $where_nombre_asentamiento=($filtro_nombre_asentamiento=='TODOS')?null:$filtro_nombre_asentamiento;

        $filtro_incorporacion = $request->filtro_incorporacion;
        $where_incorporacion=($filtro_incorporacion=='TODOS')?null:$filtro_incorporacion;
        //dd($where_tipo_asentamiento);

        $filtro_tam_est = $request->filtro_tam_est;

        $filtro_telefono=$request->filtro_telefono;
        $where_tel=($filtro_telefono=='TODOS')?null:$filtro_telefono;

        $filtro_email=$request->filtro_email;
        $where_email=($filtro_email=='TODOS')?null:$filtro_email;

        $filtro_pagina_web=$request->filtro_pagina_web;
        $where_pagina_web=($filtro_pagina_web=='TODOS')?null:$filtro_pagina_web;


        $where_tam_est=null;
        switch ($filtro_tam_est) {
            case 1: $where_tam_est='0 a 5 personas'; break;
            case 2: $where_tam_est='6 a 10 personas'; break;
            case 3: $where_tam_est='11 a 30 personas'; break;
            case 4: $where_tam_est='31 a 50 personas'; break;
            case 5: $where_tam_est='51 a 100 personas'; break;
            case 6: $where_tam_est='101 a 250 personas'; break;
            case 7: $where_tam_est='251 y más personas'; break;
        }



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
                        ->when($where_nombre_asentamiento, function ($query, $where_nombre_asentamiento) {
                            return $query->where('nombre_asentamiento_humano','like', $where_nombre_asentamiento);
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
                        ->paginate(20);
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
                        ->when($where_nombre_asentamiento, function ($query, $where_nombre_asentamiento) {
                            return $query->where('nombre_asentamiento_humano','like', $where_nombre_asentamiento);
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
                        ->paginate(20);
        }



        return [
            'pagination'=>[
                'total'=> $directories->total(),
                'current_page'=> $directories->currentPage(),
                'per_page'=> $directories->perPage(),
                'last_page'=> $directories->lastPage(),
                'from'=> $directories->firstItem(),
                'to'=> $directories->lastItem(),
            ],
            'directories'=>$directories,

        ];
    }//.get()

    public function loadAllLocalidades(Request $request){
        $regsbd = Directory::distinct()->orderBy('localidad','ASC')->get('localidad');
        $localidades=[];
        $ind=0;
        foreach($regsbd as $data){
            $ind++;
            $tmp=[
                'id'=>$ind,
                'description' => $data->localidad
            ];
            array_push($localidades,$tmp);
        }
        return $localidades;
    }

    public function loadAllAsentamientos(Request $request){
        $regsbd = Directory::distinct()->orderBy('nombre_asentamiento_humano','ASC')->get('nombre_asentamiento_humano');
        $asentamientos=[];
        $ind=0;
        foreach($regsbd as $data){
            $ind++;
            $tmp=[
                'id'=>$ind,
                'description' => $data->nombre_asentamiento_humano
            ];
            array_push($asentamientos,$tmp);
        }

        return $asentamientos;
    }//.loadAllAsentamientos()



    public function uploadDirectoryImage(Request $request){

        $directory_id =  $request->directory_id;

        $directory = Directory::findOrFail($directory_id);
        $directory->image = $request->file('image')->store('directories', 'public');
        $directory->save();

        return response()->json([
            'ok'=>true,
            'directory' => $directory,
        ]);

    }


    public function deleteDirectoryImage(Request $request){

        $directory= Directory::findOrFail($request->id);
        $file = $directory->image;
        if($file){
            $existe = Storage::disk('public')->exists($file);
            if($existe){
                Storage::disk('public')->delete($file);
            }
        }
        $directory->image=null;
        $directory->save();

        return response()->json([
            'ok'=>true,
            'directory' => $directory,
        ]);

    }//.deleteDirectoryImage()

    public function directoryExport(Request $request){
        $formato = $request->formato;
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $actividad_key = $request->actividad_key;

        $filtro_tipo_asentamiento=$request->filtro_tipo_asentamiento;
        $where_tipo_asentamiento=($filtro_tipo_asentamiento=='TODOS')?null:$filtro_tipo_asentamiento;

        $filtro_localidad = $request->filtro_localidad;
        $where_localidad=($filtro_localidad=='TODOS')?null:$filtro_localidad;

        $filtro_incorporacion = $request->filtro_incorporacion;
        $where_incorporacion=($filtro_incorporacion=='TODOS')?null:$filtro_incorporacion;
        //dd($where_tipo_asentamiento);

        $filtro_tam_est = $request->filtro_tam_est;

        $filtro_telefono=$request->filtro_telefono;
        $where_tel=($filtro_telefono=='TODOS')?null:$filtro_telefono;

        $filtro_email=$request->filtro_email;
        $where_email=($filtro_email=='TODOS')?null:$filtro_email;

        $filtro_pagina_web=$request->filtro_pagina_web;
        $where_pagina_web=($filtro_pagina_web=='TODOS')?null:$filtro_pagina_web;


        $where_tam_est=null;
        switch ($filtro_tam_est) {
            case 1: $where_tam_est='0 a 5 personas'; break;
            case 2: $where_tam_est='6 a 10 personas'; break;
            case 3: $where_tam_est='11 a 30 personas'; break;
            case 4: $where_tam_est='31 a 50 personas'; break;
            case 5: $where_tam_est='51 a 100 personas'; break;
            case 6: $where_tam_est='101 a 250 personas'; break;
            case 7: $where_tam_est='251 y más personas'; break;
        }

        if($formato=='csv'){
            return (new NewDirectoriesExport($buscar,$criterio,$actividad_key,$where_tipo_asentamiento,$where_localidad,$where_incorporacion,$where_tel,$where_email,$where_pagina_web,$where_tam_est))
                ->download(
                    'directories.csv',
                    \Nikazooz\Simplesheet\Simplesheet::CSV,
                    [
                        'Content-Type' => 'text/csv',
                    ]
                );
        }else{
            return (new NewDirectoriesExport($buscar,$criterio,$actividad_key,$where_tipo_asentamiento,$where_localidad,$where_incorporacion,$where_tel,$where_email,$where_pagina_web,$where_tam_est))->download('directories.xlsx');

        }
    }//.directoryExport()

}
