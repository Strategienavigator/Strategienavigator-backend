<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->constrained(); // onDelete and onUpdate added in `add_on_delete_cascade` migration
            $table->foreignId('user_id')->constrained(); // onDelete and onUpdate added in `add_on_delete_cascade` migration
            $table->unique(["setting_id", "user_id"]);
            $table->jsonb('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_settings');
    }
}
