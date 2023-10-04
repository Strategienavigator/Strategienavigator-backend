<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('save_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId("save_id")->constrained("saves")
                ->onDelete("CASCADE")->onUpdate("CASCADE");
            $table->string("file_name")->nullable(false);
            $table->string("file_type")->nullable(false);
            $table->string("contents_hash")->nullable(false);
            $table->string("hash_function")->nullable(false);
            $table->unique(["file_name", "save_id"]);
            $table->timestamps();
        });

        DB::statement("ALTER TABLE save_resources ADD contents MEDIUMBLOB NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save_resources');
    }
};
