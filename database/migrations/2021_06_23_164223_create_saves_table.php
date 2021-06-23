<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saves', function (Blueprint $table) {
            $table->id();
            $table->timestamp('last_opened')->nullable();
            $table->jsonb('data')->nullable();
            $table->foreignId('tool_id')->constrained(\App\Models\Tool::class);
            $table->foreignId('owner_id')->constrained(\App\Models\User::class);
            $table->foreignId('locked_by_id')->nullable()->constrained(\App\Models\User::class);
            $table->timestamp('last_locked')->nullable();
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
        Schema::dropIfExists('saves');
    }
}
