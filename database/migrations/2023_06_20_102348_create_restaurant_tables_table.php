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
        Schema::create('restaurant_tables', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('restaurant_id')->unsigned();
            $table->string('name', 100)->unique();
            $table->bigInteger('reservation_fee')->unsigned();
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_tables');
    }
};
