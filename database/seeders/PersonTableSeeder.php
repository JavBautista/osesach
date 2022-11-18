<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $person = new Person();
        $person->active=1;
        $person->name='Developer';
        $person->address='MX';
        $person->movil='+52986532';
        $person->email='dev@osesach';
        $person->date_admission='2022-01-01';
        $person->date_termination=null;
        $person->observations='SN';
        $person->save();
    }
}
