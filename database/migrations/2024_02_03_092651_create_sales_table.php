<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fk_product')->unsigned();
            $table->bigInteger('fk_user')->unsigned();
            $table->string('invoice', 50)->unique();
            $table->bigInteger('amount')->unsigned();
            $table->foreign('fk_product')->references('id')->on('products');
            $table->foreign('fk_user')->references('id')->on('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};