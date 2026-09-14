<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Agregar campos para nombres y apellidos
            $table->string('first_name', 100)->nullable()->after('id');
            $table->string('last_name', 100)->nullable()->after('first_name');
            $table->string('position', 150)->nullable()->after('email'); // cargo
            // Campos para socialite
            $table->string('provider')->nullable()->after('remember_token');
            $table->string('provider_id')->nullable()->after('provider');
            $table->string('avatar')->nullable()->after('provider_id');
            // Modificar 'photo' para que sea nullable? ya lo es.
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'position', 'provider', 'provider_id', 'avatar']);
        });
    }
};