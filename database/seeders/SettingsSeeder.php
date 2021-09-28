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
            ]
        ]);
    }
}
