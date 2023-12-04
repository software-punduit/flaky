<?php

namespace Database\Seeders;

use App\Models\Constants;
use App\Models\TransactionCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'name' => Constants::TRANSACTION_CATEGORY_FUND_WALLET
            ],
            [
                'name' => Constants::TRANSACTION_CATEGORY_WITHDRAWAL
            ],
            [
                'name' => Constants::TRANSACTION_CATEGORY_RESERVATION
            ],
            [
                'name' => Constants::TRANSACTION_CATEGORY_FEES
            ],
            [
                'name' => Constants::TRANSACTION_CATEGORY_ORDER
            ],
            
        ];

        foreach ($seeds as $seed) {
            TransactionCategory::firstOrCreate($seed);
        }
    }
}
