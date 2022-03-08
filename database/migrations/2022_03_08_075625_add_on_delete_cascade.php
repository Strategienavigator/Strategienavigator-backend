<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * add onDelete and onUpdate to various columns
     *
     * @return void
     */
    public function up()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropForeign('password_resets_user_id_foreign');
            $table->foreign('user_id', 'password_resets_user_id_foreign')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('invitation_links', function (Blueprint $table) {
            $table->dropForeign('invitation_links_save_id_foreign');
            $table->foreign('save_id', 'invitation_links_save_id_foreign')->references('id')->on('saves')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('shared_save', function (Blueprint $table) {
            $table->dropForeign('shared_save_save_id_foreign');
            $table->foreign('save_id', 'shared_save_save_id_foreign')->references('id')->on('saves')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->dropForeign('shared_save_user_id_foreign');
            $table->foreign('user_id', 'shared_save_user_id_foreign')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::table('user_settings', function (Blueprint $table) {
            $table->dropForeign('user_settings_user_id_foreign');
            $table->foreign('user_id', 'user_settings_user_id_foreign')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->dropForeign('user_settings_setting_id_foreign');
            $table->foreign('setting_id', 'user_settings_setting_id_foreign')->references('id')->on('settings')
                ->onUpdate('CASCADE')->onDelete('NO ACTION');
        });
    }

    /**
     * remove onDelete and onUpdate
     *
     * @return void
     */
    public function down()
    {
        Schema::table('password_resets', function (Blueprint $table) {
            $table->dropForeign('password_resets_user_id_foreign');
            $table->foreign('user_id', 'password_resets_user_id_foreign')->references('id')->on('users');
        });

        Schema::table('invitation_links', function (Blueprint $table) {
            $table->dropForeign('invitation_links_save_id_foreign');
            $table->foreign('save_id', 'invitation_links_save_id_foreign')->references('id')->on('saves');
        });

        Schema::table('shared_save', function (Blueprint $table) {
            $table->dropForeign('shared_save_save_id_foreign');
            $table->foreign('save_id', 'shared_save_save_id_foreign')->references('id')->on('saves');

            $table->dropForeign('shared_save_user_id_foreign');
            $table->foreign('user_id', 'shared_save_user_id_foreign')->references('id')->on('users');
        });

        Schema::table('user_settings', function (Blueprint $table) {
            $table->dropForeign('user_settings_user_id_foreign');
            $table->foreign('user_id', 'user_settings_user_id_foreign')->references('id')->on('users');

            $table->dropForeign('user_settings_setting_id_foreign');
            $table->foreign('setting_id', 'user_settings_setting_id_foreign')->references('id')->on('settings');
        });
    }
};
