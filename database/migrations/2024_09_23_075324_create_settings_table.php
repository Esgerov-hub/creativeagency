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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('header_logo',512);
            $table->string('footer_logo',512);
            $table->string('favicon',512);
            $table->string('phone',255);
            $table->string('email',255);
            $table->string('facebook',255)->nullable();
            $table->string('instagram',255)->nullable();
            $table->string('telegram',255)->nullable();
            $table->string('whatsapp',255)->nullable();
            $table->string('youtube',255)->nullable();
            $table->string('linkedin',255)->nullable();
            $table->string('twitter',255)->nullable();
            $table->json('title');
            $table->json('text')->nullable();
            $table->json('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
