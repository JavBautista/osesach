<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Directory;
use App\Models\Person;
use App\Models\User;
use App\Models\Visit;


class ReportsController extends Controller
{
    public function avanceGeneral(){

        $total_directories =  DB::table('directories')->count();
        $total_visits  =  DB::table('visits')->count();

        $total_directories_asignadas =  DB::table('directories')->where('asignada',1)->count();

        $total_directories_trabajadas =  DB::table('directories')
                                        ->where('status_id','>','0')
                                        ->count();

        $nuevas = DB::table('directories')
                        ->whereNull('id_denue')
                        ->count();

        $iniciales = $total_directories - $nuevas;

        return view('reports.avance_general',[
            'total_visits'=>$total_visits,
            'total_directories'=>$total_directories,
            'total_directories_asignadas'=>$total_directories_asignadas,
            'total_directories_trabajadas'=>$total_directories_trabajadas,
            'nuevas'=>$nuevas,
            'iniciales'=>$iniciales,
        ]);

    }

    public function avancePersonal(){

        $users = User::with('person')->where('role_id',3)->get();

        $personal=[];

        foreach ($users as $usr) {
            $prs_id = $usr->person->id;
            $prs_name = $usr->person->name;
            $trabajado =DB::table('directories')
                            ->where('agent_id',$prs_id)
                            ->where('status_id','<>',0)
                            ->count();
            $asignado = DB::table('directories')
                            ->where('agent_id',$prs_id)
                            ->count();

            $porcentaje=0;
            if($asignado>0){
                $porcentaje = ($trabajado*100)/$asignado;
            }

            $porcentaje= number_format($porcentaje,2);
            $tmp=[
                'persona_id'=>$prs_id,
                'persona_nombre'=>$prs_name,
                'trabajado'=>$trabajado,
                'asignado'=>$asignado,
                'porcentaje'=>$porcentaje,
            ];

            array_push($personal, $tmp);
        }

        /*$total_directories =  DB::table('directories')->count();
        $total_visits =  DB::table('visits')->count();

        $total_directories_asignadas =  DB::table('directories')->where('asignada',1)->count();

        $total_directories_trabajadas =  DB::table('directories')
                                        ->where('asignada',1)
                                        ->where('status_id','>','0')
                                        ->count();
        */
        return view('reports.avance_personal',[
            'personal'=>$personal,
        ]);

    }


    public function avancePersonalPersona(Request $request){
        $persona_id = $request->persona_id;
        $asignacion = Directory::where('agent_id',$persona_id)->get();
        return view('reports.avance_personal_persona',[
            'asignacion'=>$asignacion,
            'persona_id'=>$persona_id
        ]);
    }

    public function avancePersonalPersonaVisita(Request $request){
        $directory_id = $request->directory_id;
        $persona_id = $request->persona_id;

        $directory = Directory::findOrFail($directory_id);
        $visitas   = Visit::where('directory_id',$directory_id)->get();

        return view('reports.avance_personal_persona_visita',[
            'directory'=>$directory,
            'visitas'=>$visitas,
            'persona_id'=>$persona_id
        ]);
    }
}
