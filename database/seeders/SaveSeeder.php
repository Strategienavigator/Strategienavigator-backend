<?php

namespace Database\Seeders;

use App\Models\Save;
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
        Save::factory()->count(5)->create();
    }
}
