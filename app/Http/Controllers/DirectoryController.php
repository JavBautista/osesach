<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Directory;
use Illuminate\Support\Carbon;

class DirectoryController extends Controller
{
    public function index(Request $request)
    {

        $suppliers = Directory::where('active',1)
                    ->orderBy('id','desc')
                    ->paginate(5);

        return $suppliers;

    }

    public function getApiDirectoriesAgent(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $agente_id   =   $request->agente_id;
        $directories = Directory::where('active',1)
                    ->where('agent_id',$agente_id)
                    ->where('asignada',1)
                    ->orderBy('id','desc')
                    ->paginate(100);


        return $directories;
    }//.getDirectoriesAgent()


    public function asignacion(Request $request)
    {
        return view('asignacion');
    }

    public function asignar($persona_id)
    {

        return view('asignar',['persona_id'=>$persona_id]);
    }

    public function indexWeb(Request $request)
    {

        $directories = Directory::where('active',1)
                    ->orderBy('id','desc')
                    ->paginate(50);

        return view('directory',['directories'=>$directories]);

    }

    public function getDirectoriesForAssign(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar   =   $request->buscar;
        $criterio = $request->criterio;
        $num_registros = $request->num_registros;
        if($buscar==''){
            $directories = Directory::where('active',1)
                        ->where('asignada',0)
                        ->orderBy('id','desc')
                        ->limit($num_registros)
                        ->get();
        }else{

            $directories = Directory::where('active',1)
                        ->where('asignada',0)
                        ->where($criterio, 'like', '%'.$buscar.'%')
                        ->orderBy('id','desc')
                        ->limit($num_registros)
                        ->get();
        }

        return $directories;
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
        $agente_id   =   $request->agente_id;
        $buscar      =   $request->buscar;
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

    public function store(Request $request){

        $directory= Directory::findOrFail(1);
        $directory =new Directory();
        $directory->nombre_unidad = $request->nombre_unidad;
        $directory->codigo_scian =  $request->codigo_scian;
        $directory->nombre_clase_actividad = $request->nombre_clase_actividad;
        $directory->descripcion_estrato_personal_ocupado= $request->descripcion_estrato_personal_ocupado;
        $directory->nombre_vialidad  = $request->nombre_vialidad;
        $directory->numero_exterior_o_kilometro = $request->numero_exterior_o_kilometro;
        $directory->nombre_asentamiento_humano=$request->nombre_asentamiento_humano;
        $directory->codigo_postal=$request->codigo_postal;
        $directory->numero_telefono=$request->numero_telefono;
        $directory->correo_electronico=$request->correo_electronico;
        $directory->sitio_internet=$request->sitio_internet;

        $directory->latitud=$request->latitud;
        $directory->longitud=$request->longitud;

        $directory->status_id = 0;
        $directory->agent_id  = 0;
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


}
