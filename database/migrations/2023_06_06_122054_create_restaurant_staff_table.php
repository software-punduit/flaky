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
        Schema::create('restaurant_staff', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('restaurant_id')->unsigned();
            $table->bigInteger('staff_id')->unsigned();
            $table->timestamps();

            $table->foreign('restaurant_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_staff');
    }
};
