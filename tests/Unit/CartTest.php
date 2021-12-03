<?php

namespace Tests\Unit;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */    
    public function it_can_show_the_specific_item_in_the_cart()
    {
        $product = factory(Product::class)->create();
        $item = Cart::add($product, 1);

        $getItem = Cart::search(fn($v, $k) => $k == $item->rowId)->first();
        
        $this->assertEquals($product->product_name, $getItem->name);    
    }

    /** @test */    
    public function it_can_add_to_cart()
    {
        $product = factory(Product::class)->create();
        Cart::add($product, 1);

        $cart = Cart::content();
        
        $this->assertEquals($product->product_name, $cart->first()->name);    
        $this->assertEquals(1, $cart->first()->qty);    
    }

    /** @test */    
    public function it_can_update_item_in_the_cart()
    {
        $product = factory(Product::class)->create();
        Cart::add($product, 1);

        Cart::update(Cart::content()->first()->rowId, 2);

        $this->assertEquals(2, Cart::content()->first()->qty);    
    }

    /** @test */    
    public function it_can_remove_item_in_the_cart()
    {
        $product = factory(Product::class)->create();
        Cart::add($product, 1);

        Cart::remove(Cart::content()->first()->rowId);
        
        $this->assertEquals(0, Cart::count());    
    }

    /** @test */    
    public function it_can_destroy_cart()
    {
        $product = factory(Product::class)->create();
        Cart::add($product, 1);

        Cart::destroy();
        
        $this->assertEquals(0, Cart::count());    
    }
}
