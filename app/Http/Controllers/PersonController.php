<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Person;
use App\Models\TypeUser;
use App\Models\User;
use App\Models\Role;

class PersonController extends Controller
{
    public function index()
    {
        return view('people');
    }

    public function get(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $filtro_tipo = $request->filtro_tipo;

        if($buscar==''){
            $people = DB::table('people')
                        ->select('people.*','roles.description')
                        ->leftJoin('users', 'users.person_id', '=', 'people.id')
                        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                        ->orderBy('people.id', 'desc')
                        ->paginate(20);
        }else{
            $people = DB::table('people')
                        ->select('people.*','roles.description')
                        ->leftJoin('users', 'users.person_id', '=', 'people.id')
                        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                        //->leftJoin('type_users', 'people.id', '=', 'type_users.id')
                        ->where('people.'.$criterio, 'like', '%'.$buscar.'%')
                        ->orderBy('people.id','desc')
                        ->paginate(20);
        }

        return [
            'pagination'=>[
                'total'=> $people->total(),
                'current_page'=> $people->currentPage(),
                'per_page'=> $people->perPage(),
                'last_page'=> $people->lastPage(),
                'from'=> $people->firstItem(),
                'to'=> $people->lastItem(),
            ],
            'people'=>$people,

        ];
    }
    
    public function getAgents(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $agents = DB::table('people')
                        ->select('people.*','roles.description')
                        ->leftJoin('users', 'users.person_id', '=', 'people.id')
                        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                        ->where('users.role_id',3)
                        ->where('people.active',1)
                        ->orderBy('people.id', 'desc')
                        ->paginate(20);
        }
        /*else{
            $agents = DB::table('people')
                        ->select('people.*','roles.description')
                        ->leftJoin('users', 'users.person_id', '=', 'people.id')
                        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                        //->leftJoin('type_users', 'people.id', '=', 'type_users.id')
                        ->where($criterio, 'like', '%'.$buscar.'%')
                        ->orderBy('people.id','desc')
                        ->paginate(20);
        }*/

        return [
            'pagination'=>[
                'total'=> $agents->total(),
                'current_page'=> $agents->currentPage(),
                'per_page'=> $agents->perPage(),
                'last_page'=> $agents->lastPage(),
                'from'=> $agents->firstItem(),
                'to'=> $agents->lastItem(),
            ],
            'agents'=>$agents,

        ];
    }

    public function getAllActive(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $people = Person::where('active',1)->get();
        return $people;
    }


    public function store(Request $request)
    {
        $person= new Person();
        $person->active=1;
        $person->name    = $request->name;
        $person->address = $request->address;
        $person->movil   = $request->movil;
        $person->email    = $request->email;
        $person->date_admission = $request->date_admission;
        $person->date_termination = NULL;
        $person->observations = $request->observations;
        $person->save();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->person_id    = $person->id;
        $user->role_id    = $request->role_id;
        $user->save();

        $role_seller= Role::findOrFail($request->role_id)->first();
        $user->roles()->attach($role_seller);

    }

    public function update(Request $request)
    {
        $person= Person::findOrFail($request->id);
        $person->name = $request->name;
        $person->address = $request->address;
        $person->movil = $request->movil;
        $person->email = $request->email;
        $person->date_admission = $request->date_admission;
        $person->observations = $request->observations;
        $person->save();
    }

    public function active(Request $request)
    {
        $person= Person::findOrFail($request->id);
        $person->active=1;
        $person->save();
    }

    public function inactive(Request $request)
    {
        $person= Person::findOrFail($request->id);
        $person->active=0;
        $person->save();
    }

    public function getPersonaInformation(Request $request){

        $persona_id = $request->persona_id;
        $persona = Person::findOrFail($persona_id);
        return $persona;
    }


    public function getApiSupervisores(){

        $supervisores = DB::table('people')
                        ->select('people.*','roles.description')
                        ->leftJoin('users', 'users.person_id', '=', 'people.id')
                        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                        ->where('users.role_id',4)
                        ->where('people.active',1)
                        ->orderBy('people.id', 'desc')
                        ->paginate(10);
        return $supervisores;
    }

    public function getApiAgentes(){

        $supervisores = DB::table('people')
                        ->select('people.*','roles.description')
                        ->leftJoin('users', 'users.person_id', '=', 'people.id')
                        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                        ->where('users.role_id',3)
                        ->where('people.active',1)
                        ->orderBy('people.id', 'desc')
                        ->paginate(20);
        return $supervisores;
    }
}
