<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Thesis;

class PlaceOfPublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Thesis::all() as $thesis)
        {
            $thesis->place_of_publication = "Quezon City";
            $thesis->save();
        }
    }
}
