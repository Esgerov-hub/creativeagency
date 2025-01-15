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
        Schema::create('structures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('institute_categories')->onDelete('restrict');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('parent_position_id')->nullable();
            $table->string('file',512)->nullable();
            $table->json('full_name');
            $table->json('title');
            $table->json('slug');
            $table->json('text')->nullable();
            $table->json('fulltext')->nullable();
            $table->string('email',225)->nullable();
            $table->string('phone',11)->nullable();
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
        Schema::dropIfExists('structures');
    }
};
