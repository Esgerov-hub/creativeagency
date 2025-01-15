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
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('tariff_categories')->onDelete('restrict');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('sub_parent_id')->nullable();
            $table->json('title');
            $table->json('slug');
            $table->json('unit_of_measure')->nullable();
            $table->json('service_charge')->nullable();
            $table->integer('order_by')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
