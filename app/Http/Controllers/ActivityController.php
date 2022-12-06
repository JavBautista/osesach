<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        if($buscar==''){
            $activities = Activity::orderBy('id','desc')
                    ->paginate(10);
        }else{
            $activities = Activity::where('activity', 'like', '%'.$buscar.'%')
                    ->orderBy('id','desc')
                    ->paginate(10);
        }
        return $activities;
    }

    public function inicio(){
        return view('activities');
    }

    public function get(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $activities = Activity::orderBy('activity', 'asc')
                        ->paginate(20);
        }else{
            $activities = Activity::where($criterio, 'like', '%'.$buscar.'%')
                        ->orderBy('activity', 'asc')
                        ->paginate(20);
        }

        return [
            'pagination'=>[
                'total'=> $activities->total(),
                'current_page'=> $activities->currentPage(),
                'per_page'=> $activities->perPage(),
                'last_page'=> $activities->lastPage(),
                'from'=> $activities->firstItem(),
                'to'=> $activities->lastItem(),
            ],
            'activities'=>$activities,

        ];
    }

    public function loadAllActivities(){
        $activities= Activity::all();
        return $activities;
    }

    public function store(Request $request)
    {
        $act= new Activity();
        $act->key       = $request->key;
        $act->activity  = $request->activity;
        $act->save();
    }

    public function update(Request $request)
    {
        $act= Activity::findOrFail($request->id);
        $act->key      = $request->key;
        $act->activity = $request->activity;
        $act->save();
    }
}
