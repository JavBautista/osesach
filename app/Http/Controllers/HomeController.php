<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\User;

use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload(Request $request){

        //dd($request);
        if($request->hasFile('test_image')){
            //$product = Product::find($request->product_id);
            //$file = $product->image;
            /*if($file){
                $existe = Storage::disk('public')->exists($file);
                if($existe){
                    Storage::disk('public')->delete($file);
                }
            }*/
            //$product->image = $request->file('main_image')->store('products', 'public');
            $request->file('test_image')->store('testimage', 'public');

            Session::flash('alert', 'Imagen actualizada exitosamente ');
            Session::flash('alert-class', 'alert-success');
            return redirect("/test");
        }else{
            Session::flash('alert', 'No se recibio ninguna imagen en el input file. ');
            Session::flash('alert-class', 'alert-danger');
            return redirect("/test");
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['adminsys']);
        return view('home');

        /*
            $request->user()->authorizeRoles(['admin', 'seller', 'buyer']);
            if($request->user()->hasRole('admin'))
                return redirect('/admin');
            if($request->user()->hasRole('seller'))
                return redirect('/seller');
        */
    }

    public function passwordReset(Request $request){
        return view('user.reset_password');
    }

    public function updatePassword(Request $request){

        $user_id=$request->user()->id;
        $user = User::find($user_id);
        $user->password = Hash::make( $request->input('password') );
        $user->setRememberToken(Str::random(60));
        $user->save();

        $this->guard()->login($user);

        /*
            $request->user()->authorizeRoles(['seller', 'admin', 'buyer']);

            if($request->user()->hasRole('seller'))
                return redirect('/seller');

            if($request->user()->hasRole('buyer'))
                return redirect('/buyer');

            if($request->user()->hasRole('admin'))
                return redirect('/admin');

            return redirect('/');
            //return view('user.reset_password');
        */
        return redirect('/');

    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function descargas(){
        return view('descargas');
    }

    public function importacion(){
        return view('importacion');
    }

    public function testExport(){
        return Excel::download(new UsersExport, 'users.xlsx');
    }

}
