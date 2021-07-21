<?php

namespace Database\Seeders;

use App\Models\Save;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User([
            "username"=>"test_user",
            "email"=>"max@test.test",
            "anonym"=>false,
            "email_verified_at"=>Carbon::now(),
            "password"=>"password"
        ]);
        $user->save();
        User::factory()->count(20)->has(Save::factory()->count(2),'saves')->create();
    }
}
