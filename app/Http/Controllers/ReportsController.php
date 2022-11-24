<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Directory;
use App\Models\Person;
use App\Models\User;


class ReportsController extends Controller
{
    public function avanceGeneral(){

        $total_directories =  DB::table('directories')->count();
        $total_visits =  DB::table('visits')->count();

        $total_directories_asignadas =  DB::table('directories')->where('asignada',1)->count();

        $total_directories_trabajadas =  DB::table('directories')
                                        ->where('asignada',1)
                                        ->where('status_id','>','0')
                                        ->count();

        return view('reports.avance_general',[
            'total_visits'=>$total_visits,
            'total_directories'=>$total_directories,
            'total_directories_asignadas'=>$total_directories_asignadas,
            'total_directories_trabajadas'=>$total_directories_trabajadas,
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
            $porcentaje = ($trabajado*100)/$asignado;
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
}
