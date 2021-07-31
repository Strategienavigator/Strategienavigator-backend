<?php

namespace Database\Seeders;

use App\Models\Save;
use App\Models\User;
use Illuminate\Database\Seeder;

class SaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            // manual lopp got get a random user for each save
            Save::factory()->for(User::all()->random(), 'owner')->create();
        }
    }
}
