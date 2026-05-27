<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_storagage_preferences', function (Blueprint $table) {
            $table->id();
            $table->string('mode');
            $table->unsignedBigInteger('whmcs_user_id');
            $table->foreign('whmcs_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('whmcs_service_id');
            $table->foreign('whmcs_service_id')->references('id')->on('apps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_storagage_preferences');
    }
};
