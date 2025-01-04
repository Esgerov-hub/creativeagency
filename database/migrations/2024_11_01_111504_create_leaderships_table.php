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
        Schema::create('leaderships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('institute_categories')->onDelete('restrict');
            $table->unsignedBigInteger('position_id')->index();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('restrict');
            $table->unsignedBigInteger('parent_position_id')->index();
            $table->foreign('parent_position_id')->references('id')->on('positions')->onDelete('restrict');
            $table->string('image',512)->nullable();
            $table->json('full_name');
            $table->json('slug');
            $table->json('fulltext')->nullable();
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
        Schema::dropIfExists('leaderships');
    }
};
