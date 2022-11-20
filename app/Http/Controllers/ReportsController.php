<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Directory;


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
}
