<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'stripe_plan' => 'price_1MPuBdKh1i2J84rh2ei5K7XA',
                'price' => 10,
                'description' => 'Basic'
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'stripe_plan' => 'price_1MPuBdKh1i2J84rh7dJL7Tqs',
                'price' => 100,
                'description' => 'Premium'
            ],
            [
                'name' => 'One day trial',
                'slug' => 'one-day-trial',
                'stripe_plan' => 'price_1MQ6ZIKh1i2J84rhPvS0eo5h',
                'price' => 1,
                'description' => 'one-day-trial'
            ]
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
