<?php

namespace Database\Seeders;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insert([
            [
                "id" => 1,
                "name" => "Dark Mode",
                "description" => "Ändert das Aussehen der Oberfläche. Der Dark Mode ist bei einer dunklen Umgebung am Besten geeignet",
                "type" => "toggle",
                "extras" => null,
                "default" => "false"
            ],
            [
                "id" => 2,
                "name" => "Portfolio-Analyse Quadranten",
                "description" => "Es lassen sich die Beschriftung der Quadranten einstellen oder komplett ausblenden.",
                "type" => "portfolio-quadrants",
                "extras" => null,
                "default" => '{"toggled":false,"quadrants":[{"value":"Oben Links","header":"Oben Links"},{"value":"Oben Rechts","header":"Oben Rechts"},{"value":"Unten Links","header":"Unten Links"},{"value":"Unten Rechts","header":"Unten Rechts"}]}'
            ]
        ]);
    }
}
