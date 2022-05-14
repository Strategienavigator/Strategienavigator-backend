<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('token')->primary();
            $table->foreignId("user_id")->constrained(); // onDelete and onUpdate added in `add_on_delete_cascade` migration
            $table->timestamp("expiry_date")->nullable();
            $table->boolean('password_changed');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('password_changed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
