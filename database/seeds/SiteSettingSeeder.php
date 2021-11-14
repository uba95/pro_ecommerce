<?php

use App\Models\SiteSettings;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = ['created_at'=> now(), 'updated_at'=> now()];
        
        SiteSettings::insert(
            [
                'phone' =>	'719-541-4872',
                'email' =>	'123@gmail.com',
                'address' =>	'home1',
                'facebook' => 'facebook.com',
                'youtube' => 	'youtube.com',
                'twitter' => 	'twitter.com',
            ] +  $time
        );

    }
}
