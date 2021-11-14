<?php

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = ['created_at'=> now(), 'updated_at'=> now()];

        Coupon::insert(array_map(fn($v) => $v + $time,
            [
                [ 'coupon_name' => 'NEW', 'status' => 1, 'discount' => 10,
                'max_use_count' => 100, 'started_at' => now(), 'expired_at' => now()->addYear()],

                [ 'coupon_name' => 'GOLD', 'status' => 1, 'discount' => 50,
                'max_use_count' => 5, 'started_at' => now(), 'expired_at' => now()->addYear()],

                [ 'coupon_name' => 'DIAMOND', 'status' => 1, 'discount' => 80,
                'max_use_count' => 1, 'started_at' => now(), 'expired_at' => now()->addYear()],
            ]   
        ));
    }
}
