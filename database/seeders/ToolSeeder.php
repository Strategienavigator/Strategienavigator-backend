<?php

namespace Database\Seeders;

use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tool::insert([
            [
                "id"=>1,
                "name"=>"Nutzwertanalyse",
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()

            ],
            [
                "id"=>2,
                "name"=>"SWOT-Analyse",
                "created_at"=>Carbon::now(),
                "updated_at"=>Carbon::now()
            ],
        ]);
    }
}
