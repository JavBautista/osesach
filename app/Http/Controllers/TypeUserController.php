<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class TypeUserController extends Controller
{

    public function getAll(Request $request){
        if(!$request->ajax()) return redirect('/');
        $roles_user = Role::all();
        return  $roles_user;
    }//.getAll
}
