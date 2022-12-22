<?php

namespace App\Exports;

use App\Models\Directory;
use Nikazooz\Simplesheet\Concerns\FromCollection;

class NewDirectoriesExport implements FromCollection
{
    public function collection()
    {
        return Directory::all();
    }
}