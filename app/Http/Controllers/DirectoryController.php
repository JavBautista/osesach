<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Directory;

class DirectoryController extends Controller
{
    public function index(Request $request)
    {

        $suppliers = Directory::where('active',1)
                    ->orderBy('id','desc')
                    ->paginate(5);

        return $suppliers;

    }

}
