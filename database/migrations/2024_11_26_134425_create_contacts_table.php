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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('surname',255);
            $table->string('phone',255);
            $table->string('email',255);
            $table->text('note')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->dateTime('datetime')->default(\Carbon\Carbon::now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
