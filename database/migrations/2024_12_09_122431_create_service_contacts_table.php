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
        Schema::create('service_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->nullable();
            $table->string('full_name',255);
            $table->string('region_name',255);
            $table->string('tin_enterprise',255);
            $table->string('training_topic',255);
            $table->string('training_format',255);
            $table->integer('employees_count')->default(0);
            $table->integer('contract_value')->default(0);
            $table->string('application_example',512)->nullable();
            $table->string('card_speed',512)->nullable();
            $table->string('bank_visits',255)->nullable();
            $table->string('power_of_attorney',512)->nullable();
            $table->string('phone',255);
            $table->string('address',255);
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
        Schema::dropIfExists('service_contacts');
    }
};
