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
        Schema::create('career_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('career_id')->nullable();
            $table->string('name',255);
            $table->string('surname',255);
            $table->string('father_name',255);
            $table->date('birthday')->nullable();
            $table->string('gender',255)->nullable();
            $table->string('phone',255);
            $table->string('email',255);
            $table->string('address',255);
            $table->string('actual_address',255)->nullable();
            $table->json('education');
            $table->json('experience')->nullable();
            $table->json('language');
            $table->string('volunteer_expectations',255)->nullable();
            $table->string('volunteer_differences',255)->nullable();
            $table->tinyInteger('is_volunteer')->default(0);
            $table->string('voluntary_other_text',255)->nullable();
            $table->string('voluntary_leaving_reason',255)->nullable();
            $table->string('image',512)->nullable();
            $table->string('resume',512)->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->tinyInteger('is_vacancy')->default(0);
            $table->dateTime('datetime')->default(\Carbon\Carbon::now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_contacts');
    }
};
