<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_show_empty_cart()
    {
        $this->get(route('cart.show'))->assertOk()->assertSee('Your Cart Is Empty');         
    }
    
    /** @test */    
    public function it_can_add_to_cart()
    {
        $product = factory(Product::class)->create();

        $this
            ->addToCart($product)
            ->assertJson([
                'cart_count' =>  1,
                'cart_price' => $product->price,    
                'success' => 'Product Added To Your Cart',
            ]);
    }

    /** @test */    
    public function it_errors_when_add_not_valid_product_id_to_cart()
    {
        $this
            ->post(route('cart.store', [
                'product' => 'xxx',
                'product_quantity' => 1
            ]))
            ->assertSessionHas(['message' => "Product Is Not Found"]);
    }

    /** @test */
    public function it_errors_when_add_to_cart_without_the_quantity()
    {
        $product = factory(Product::class)->create();

        $this
            ->addToCart($product, null)
            ->assertJson(['error' => 'This Quantity Is Not Valid']);
    }

    /** @test */
    public function it_errors_when_add_to_cart_while_quantity_is_string()
    {
        $product = factory(Product::class)->create();

        $this
            ->addToCart($product, 'string')
            ->assertJson(['error' => 'This Quantity Is Not Valid']);
    }

    /** @test */
    public function it_errors_when_add_to_cart_while_quantity_is_less_than_1()
    {
        $product = factory(Product::class)->create();

        $this
            ->addToCart($product, 0)
            ->assertJson(['error' => 'This Quantity Is Not Valid']);
    }

    /** @test */
    public function it_can_show_cart()
    {
        $product = factory(Product::class)->create();
        $this->addToCart($product);

        $this
            ->get(route('cart.show'))
            ->assertOk()
            ->assertSee($product->product_name);
    }

    /** @test */    
    public function it_can_update_item_in_the_cart()
    {
        $product = factory(Product::class)->create();
        $this->addToCart($product);

        $item = Cart::content()->first();

        $this
            ->updateCartItem($item)           
            ->assertJson([
                'cart_count' =>  2,
                'cart_price' => 2 * $product->price,    
            ]);
    }

    /** @test */
    public function it_errors_when_update_not_valid_cart_item_id_to_cart()
    {
        $this
            ->patch(route('cart.update', [
                'cartItem' => 'xxx',
                'quantity' => 2
            ]))
            ->assertJson(['error' => 'Cart Item Not Found']);
    }

    /** @test */
    public function it_errors_when_the_cart_while_quantity_is_string()
    {
        $product = factory(Product::class)->create();
        $this->addToCart($product);

        $item = Cart::content()->first();

        $this
            ->updateCartItem($item, 'string')
            ->assertJson(['error' => 'This Quantity Is Not Valid']);
    }

    /** @test */
    public function it_errors_when_update_the_cart_while_quantity_is_less_than_1()
    {
        $product = factory(Product::class)->create();
        $this->addToCart($product);

        $item = Cart::content()->first();

        $this
            ->updateCartItem($item, 0)
            ->assertJson(['error' => 'This Quantity Is Not Valid']);
    }

    /** @test */    
    public function it_can_remove_item_in_the_cart()
    {
        $product = factory(Product::class)->create();
        $this->addToCart($product);

        $item = Cart::content()->first();

        $this
            ->delete(route('cart.destroy', ['cartItem' => $item->rowId]))            
            ->assertJson([
                'cart_count' =>  0,
                'cart_price' => 0,    
            ]);
    }

    /** @test */
    public function it_errors_when_remove_not_valid_cart_item_id_to_cart()
    {
        $this
            ->patch(route('cart.destroy', ['cartItem' => 'xxx']))
            ->assertJson(['error' => 'Cart Item Not Found']);
    }

    /** @test */    
    public function it_can_destroy_cart()
    {
        $product = factory(Product::class)->create();
        $this->addToCart($product);

        $this
            ->delete(route('cart.destroyAll'))            
            ->assertJson([
                'cart_count' =>  0,
                'cart_price' => 0,    
            ]);
    }

    private function addToCart($product, $quantity = 1) {
        return $this->post(route('cart.store', [
            'product' => $product->id,
            'product_quantity' => $quantity
        ]));
    }

    private function updateCartItem($item, $quantity = 2) {
        return $this->patch(route('cart.update', [
            'cartItem' => $item->rowId,
            'quantity' => $quantity
        ]));           
    }
}
