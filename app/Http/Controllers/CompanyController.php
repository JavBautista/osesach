<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function getInformation(){
        $company=Company::findOrFail(1);
        return $company;
    }
}
