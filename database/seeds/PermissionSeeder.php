<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Arr;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $time = ['created_at'=> now(), 'updated_at'=> now()];
        $data = [ 'guard_name' => 'admin'] + $time;
        $permissions = [
            "view admins",          "create admins",        "edit admins",              "delete admins",
            "view products",        "create products",      "edit products",            "delete products",
            "view roles",           "create roles",         "edit roles",               "delete roles",
            "view permissions",     "create permissions",   "edit permissions",         "delete permissions",
            "view categories",      "create categories",    "edit categories",          "delete categories",
            "view coupons",         "create coupons",       "edit coupons",             "delete coupons",
            "view blog",            "create blog",          "edit blog",                "delete blog",
            "view customers",                                                           "delete customers",
            "view contact messages",                        "reply contact messages",   "delete contact messages",
            "view orders",                                  "edit orders",
            "view newslaters",                                                          "delete newslaters",
            "view stocks",
            "view reports",
            "view site settings",                           "edit site settings",
        ];

        Permission::insert(array_map(
            fn($v, $k) => ['id' => $k + 1, 'name' => $v] + $data,
            array_values($permissions), 
            array_keys($permissions)
        ));
        
        Role::create(['name' => 'Super Admin']);

        Role::create(['name' => 'Administrator'])->givePermissionTo([
            "view admins",            "create admins",      "edit admins",              "delete admins",
            "view categories",        "create categories",  "edit categories",          "delete categories",
            "view products",          "create products",    "edit products",            "delete products",
            "view blog",              "create blog",        "edit blog",                "delete blog",
            "view coupons",           "create coupons",     "edit coupons",             "delete coupons",
            "view customers",                                                           "delete customers",
            "view contact messages",                        "reply contact messages",   "delete contact messages",
            "view newslaters",                                                          "delete newslaters",
            "view roles",
            "view permissions",
            "view site settings",                           "edit site settings",        
        ]);

        Role::create(['name' => 'Sales Team'])->givePermissionTo([
            "view products", 
            "view categories", 
            "view customers",
            "view orders",  "edit orders",
            "view stocks",
            "view reports",
            "view contact messages", "reply contact messages",   "delete contact messages",
        ]);

        Role::create(['name' => 'Marketer'])->givePermissionTo([
            "view products",
            "view categories",
            "view blog", "create blog", "edit blog", "delete blog",            
            "view customers",
            "view orders",
            "view stocks",
            "view reports" ,
            "view newslaters",
            "view contact messages",  "reply contact messages",   "delete contact messages",       
        ]);

        $ad = ['email_verified_at' => true, 'password' => bcrypt(111)];

        Admin::create([ 'name' => 'aaa', 'email' => '123@gmail.com'] + $ad)->assignRole('Super Admin');
        Admin::create([ 'name' => 'bbb', 'email' => 'bb@gmail.com'] + $ad)->assignRole('Administrator');
        Admin::create([ 'name' => 'ccc', 'email' => 'cc@gmail.com'] + $ad)->assignRole('Sales Team');
        Admin::create([ 'name' => 'ddd', 'email' => 'dd@gmail.com'] + $ad)->assignRole('Marketer');
        Admin::create([ 'name' => 'eee', 'email' => 'ee@gmail.com'] + $ad)->assignRole('Sales Team', 'Marketer');
    }
}

// Permission::insert(array_map(fn($v) => array_merge([$v], $data), 
// array_merge( 
//     array_map(fn ($v) => implode('', $v), Arr::crossJoin(['view_', 'create_', 'edit_', 'delete_'], [ 'admins', 'products', 'roles', 'blog_posts', 'permissions', 'categories', 'subcategories', 'brands', 'coupons', 'blog_categories', 'customers' ]) ), 
//     array_map(fn ($v) => implode('', $v), Arr::crossJoin(['view_', 'edit_'], ['orders', 'cancel_orders', 'return_orders']) ), 
//     array_map(fn ($v) => implode('', $v), Arr::crossJoin(['view_'], ['stocks', 'reports']) ) 
// )
// ));
// [
//     "view admins",
//     "view products",
//     "view roles",
//     "view blog posts",
//     "view permissions",
//     "view categories",
//     "view subcategories",
//     "view brands",
//     "view coupons",
//     "view blog categories",
//     "view customers",
//     "create admins",
//     "create products",
//     "create roles",
//     "create blog posts",
//     "create permissions",
//     "create categories",
//     "create subcategories",
//     "create brands",
//     "create coupons",
//     "create blog categories",
//     "create customers",
//     "edit admins",
//     "edit products",
//     "edit roles",
//     "edit blog posts",
//     "edit permissions",
//     "edit categories",
//     "edit subcategories",
//     "edit brands",
//     "edit coupons",
//     "edit blog categories",
//     "edit customers",
//     "delete admins",
//     "delete products",
//     "delete roles",
//     "delete blog posts",
//     "delete permissions",
//     "delete categories",
//     "delete subcategories",
//     "delete brands",
//     "delete coupons",
//     "delete blog categories",
//     "delete customers",
//     "view orders",
//     "view cancel orders",
//     "view return orders",
//     "edit orders",
//     "edit cancel orders",
//     "edit return orders",
//     "view stocks",
//     "view reports"
// ];