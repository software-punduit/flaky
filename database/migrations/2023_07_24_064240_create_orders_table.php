<?php

use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('restaurant_id')->unsigned();
            $table->bigInteger('restaurant_owner_id')->unsigned();
            $table->bigInteger('sub_total')->unsigned()->default(0);
            $table->bigInteger('discount')->unsigned()->default(0);
            $table->bigInteger('net_total')->unsigned()->default(0);
            $table->string('status', 100)->default(Order::STATUS_PENDING);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('restrict');
            $table->foreign('restaurant_owner_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
