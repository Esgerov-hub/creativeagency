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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('restrict');
            $table->string('image');
            $table->json('slider_image')->nullable();
            $table->json('title');
            $table->json('slug');
            $table->json('text')->nullable();
            $table->json('fulltext')->nullable();
            $table->integer('order_by')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->dateTime('datetime')->default(\Carbon\Carbon::now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
