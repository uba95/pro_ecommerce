<?php

use App\Models\User;
use App\Models\Address;
use App\Models\Product;
use App\Models\HotDealProduct;
use App\Models\LandingPageItem;
use App\Models\ProductRating;
use App\Models\ProductReview;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class UserProdcutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersCount = 20;
        $productsCount = 50;
        $ratingsCount = 200;
        $reviewsCount = 100;
        $LandingPageItemsCount = 10;
        $hotDealProductsCount = 5;
        
        $faker = Faker\Factory::create();
        $users = factory(User::class, $usersCount)->create();
        $products = factory(Product::class, $productsCount)->create();
        $productsWithDiscount = $products->whereNotNull('discount_price');

        $users->each(fn($v) => factory(Address::class, rand(1, 2))->create(['user_id' => $v->id]));
        $products->each(fn($v) => factory(ProductImage::class, rand(3, 4))->create(['product_id' => $v->id]));        
        $this->randUserProdcut(ProductRating::class, $users, $products,  $ratingsCount);
        $this->randUserProdcut(ProductReview::class, $users, $products,  $reviewsCount);

        for ($i=0; $i < $LandingPageItemsCount; $i++) { 
            factory(LandingPageItem::class)->create(['product_id' => $products->random()->id]);
        }
		
		$hotDealProductsIds = [];

        for ($i=0; $i < $hotDealProductsCount; $i++) { 

            $product_id = $productsWithDiscount->random()->id;
            $hotDealProductsIds[] = $product_id;
            
		    if (!checkArrayElementsAreUnique($hotDealProductsIds)) {
                $i--;
                array_pop($hotDealProductsIds);
                continue;
            }

            factory(HotDealProduct::class)->create(['product_id' => $product_id]);
        }
    }

    private function randUserProdcut($class, $users, $products, $count) {

        $userProdcut = [];
        $i = 0;
        
        while ($i++ < $count) { 
    
            $user_id = $users->random()->id;
            $product_id = $products->random()->id;
            $userProdcut[] = $user_id . $product_id;

            if (!checkArrayElementsAreUnique($userProdcut)) {
                $i--;
                array_pop($userProdcut);
                continue;
            }

            factory($class)->create([
                'user_id' => $user_id,
                'product_id' => $product_id
            ]);
        }
    }

}
