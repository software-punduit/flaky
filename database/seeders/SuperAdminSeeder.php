<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                'name' => "Adeyemi Bolaji",
                'email' => 'ade2020@gmail.com',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now()
            ],
        ];

        foreach ($seeds as $seed) {
            $user = User::firstOrCreate(
                [
                    'email' => $seed['email']
                ],
                $seed
            );
            $user->assignRole(User::SUPER_ADMIN);
        }
        
    }
}
