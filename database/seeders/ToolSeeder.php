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
        $now = Carbon::now();
        Tool::insert([
            [
                "id" => 9999,
                "name" => "Test-Analyse (DEV only)",
                "created_at" => $now,
                "updated_at" => $now

            ],
            [
                "id" => 1,
                "name" => "Nutzwertanalyse",
                "created_at" => $now,
                "updated_at" => $now

            ],
            [
                "id" => 2,
                "name" => "SWOT-Analyse",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id" => 3,
                "name" => "Paarweiser Vergleich",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id" => 4,
                "name" => "Portfolio-Analyse",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id" => 5,
                "name" => "ABC-Analyse",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "id" => 6,
                "name" => "Persona-Analyse",
                "created_at" => $now,
                "updated_at" => $now
            ]
        ]);
    }
}
