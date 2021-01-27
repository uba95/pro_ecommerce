<?php

use App\Admin;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $ads = [
            [
                'name' => 'aaa',
                'email' => '123@gmail.com',
                'password' => bcrypt(111),
            ],
        ];
    
        foreach ($ads as $ad) {
            Admin::create($ad);
        }

    }
}