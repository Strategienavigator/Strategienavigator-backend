<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedSafeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shared_safe', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained(\App\Models\User::class);
            $table->foreignId("save_id")->constrained(\App\Models\Save::class);
            $table->integer("permission");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shared_safe');
    }
}
