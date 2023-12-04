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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payer_id')->unsigned()->nullable();
            $table->bigInteger('payee_id')->unsigned()->nullable();
            $table->bigInteger('transaction_category_id')->unsigned();
            $table->bigInteger('transaction_status_id')->unsigned();
            $table->bigInteger('amount')->unsigned();
            $table->bigInteger('payee_balance_before')->unsigned()->default(0);
            $table->bigInteger('payee_balance_after')->unsigned()->default(0);
            $table->bigInteger('payer_balance_before')->unsigned()->default(0);
            $table->bigInteger('payer_balance_after')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('transaction_category_id')->references('id')->on('transaction_categories')->onDelete('restrict');
            $table->foreign('transaction_status_id')->references('id')->on('transaction_statuses')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
