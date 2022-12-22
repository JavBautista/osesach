<?php

namespace App\Exports;

use App\Models\User;
use Nikazooz\Simplesheet\Concerns\FromCollection;

class TestUserExport implements FromCollection
{
    public function collection()
    {
        return User::all();
    }
}