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
        Schema::create('rewarded_ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('type');
            $table->text('filepath');
            $table->text('text');
            $table->string('status')->default('active');
            $table->string('redirect_link')->nullable();
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
        Schema::dropIfExists('rewarded_ads');
    }
};
