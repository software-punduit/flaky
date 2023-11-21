<?php

namespace Database\Seeders;

use App\Models\Constants;
use Illuminate\Database\Seeder;
use App\Models\TransactionStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
              'name' => Constants::TRANSACTION_STATUS_COMPLETE 
            ],
            [
              'name' => Constants::TRANSACTION_STATUS_PENDING 
            ],
            [
              'name' => Constants::TRANSACTION_STATUS_CANCELLED 
            ],   
        ];

        foreach ($seeds as $seed) {
            TransactionStatus::firstOrCreate($seed);
        }
    }
}
