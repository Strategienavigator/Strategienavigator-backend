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

            $table->jsonb('data')->nullable();
            $table->foreignId('tool_id')->constrained('tools');
            $table->foreignId('owner_id')->constrained('users');
            $table->foreignId('locked_by_id')->nullable()->constrained('users');
            $table->timestamp('last_locked')->nullable();
            $table->timestamp('last_opened')->nullable();
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
