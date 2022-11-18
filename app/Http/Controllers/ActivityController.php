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
}
