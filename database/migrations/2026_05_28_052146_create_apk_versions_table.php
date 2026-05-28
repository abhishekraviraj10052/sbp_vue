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
        Schema::create('apk_versions', function (Blueprint $table) {
            $table->id();
            $table->string('apk_file_name');
            $table->string('apk_version_name');
            $table->string('apk_version_code');
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
        Schema::dropIfExists('apk_versions');
    }
};
