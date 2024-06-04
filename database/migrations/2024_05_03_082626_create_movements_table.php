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
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->integer('amount');
            $table->string('location');
            $table->unsignedBigInteger('id_item');
            $table->foreign('id_item')->references("id")->on("items");
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references("id")->on("users");
            $table->unsignedBigInteger('id_logistics_center');
            $table->foreign('id_logistics_center')->references("id")->on("logistics_centers");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
