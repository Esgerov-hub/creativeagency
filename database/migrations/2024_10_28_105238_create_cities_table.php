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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('slug');
            $table->tinyInteger('status')->default(1);
            $table->integer('enable')->nullable()->default(0);
            $table->string('abbreviation')->nullable();
            $table->longText('path')->nullable();
            $table->string('xPos')->nullable();
            $table->string('yPos')->nullable();
            $table->string('srcWidth')->nullable();
            $table->string('srcHeight')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
