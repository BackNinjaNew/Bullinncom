<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fk_type_user')->unsigned();
            $table->string('document', 10);
            $table->string('firstname', 50);
            $table->string('lastname', 50);
            $table->string('email', 50)->unique();
            $table->string('phone', 10);
            $table->string('address', 100);
            $table->string('password', 100);
            $table->foreign('fk_type_user')->references('id')->on('type_users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};