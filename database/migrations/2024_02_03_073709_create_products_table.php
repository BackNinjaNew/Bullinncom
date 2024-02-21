<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fk_category')->unsigned();
            $table->string('code', 50)->unique();
            $table->string('name', 50);
            $table->string('description', 2000);
            $table->string('brand', 50);
            $table->bigInteger('stock')->unsigned();
            $table->double('price', 20, 2);
            $table->string('image', 50);
            $table->string('state', 20);
            $table->foreign('fk_category')->references('id')->on('categories');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};