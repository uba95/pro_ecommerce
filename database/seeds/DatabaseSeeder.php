<?php

use App\Models\Coupon;
use App\Models\SiteSettings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

		$this->truncateAllTables();
        $this->call(CountrySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(UserProdcutSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(BlogSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(SiteSettingSeeder::class);
    }

    private function truncateAllTables() {
        $database = 'Tables_in_' . DB::getDatabaseName();
        DB::statement("SET foreign_key_checks=0");
        foreach (DB::select('SHOW TABLES') as $table) {
            if ($table->{$database} !== 'migrations')
                DB::table($table->{$database})->truncate();
        }
        DB::statement("SET foreign_key_checks=1");
    }
}
