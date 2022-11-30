<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Directory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::with('directory')->orderBy('id','desc')->paginate(15);
        return $visits;
    }

    public function uploadImage(Request $request){

        $request->file('test_image')->store('testimage', 'public');
        return response()->json([
            'ok'=>true,
            'result' => 'test img'
        ]);

    }

    public function getAvance(Request $request)
    {
        $directory_id=$request->directory_id;
        $person_id=$request->person_id;

        $visits = Visit::with('directory')
                    ->with('status')
                    ->where('user_id',$person_id)
                    ->where('directory_id',$directory_id)
                    ->orderBy('id','desc')
                    ->paginate(500);
        return $visits;
    }


    public function store(Request $request){

        $date_today     = Carbon::now();

        $estatus_id =1;
        $user_id    = ($request->user_id)?$request->user_id:1;

        if($request->status=='VALIDADO CORRECTAMENTE') $estatus_id=1;
        if($request->status=='NEGOCIO CERRADO') $estatus_id=2;
        if($request->status=='NO LOCALIZADO') $estatus_id=3;
        if($request->status=='DOMICILIO INCORRECTO') $estatus_id=4;
        if($request->status=='OTRO ESTABLECIMIENTO') $estatus_id=5;

        $visit =new Visit();
        $visit->directory_id  = $request->directory_id;
        $visit->user_id       = $user_id;
        $visit->status_id     = $estatus_id;
        $visit->observations  = $request->observations;

        $visit->no_personas_hombres = $request->no_personas_hombres;
        $visit->no_personas_mujeres = $request->no_personas_mujeres;
        $visit->rango_edades        = $request->rango_edades;
        $visit->consulta        = $request->consulta;
        $visit->latitud        = $request->latitud;
        $visit->longitud        = $request->longitud;

        $visit->save();

        $directory = Directory::findOrFail($request->directory_id);
        $directory->status_id=$estatus_id;
        $directory->fecha_status=$date_today;
        $directory->save();

        $vs=Visit::with('directory')->find($visit->id);
        return response()->json([
            'ok'=>true,
            'visit' => $vs,
        ]);
    }
}
