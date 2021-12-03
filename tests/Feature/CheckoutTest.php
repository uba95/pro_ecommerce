<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Country;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_shows_the_login_form_when_customer_not_logged_in()
    {
        $res = $this->get(route('checkout.index'))->assertRedirect(route('login'));
        $this->followRedirects($res)
            ->assertOk()
            ->assertSee('Email')
            ->assertSee('Password')
            ->assertSee('Login');
    }

    /** @test */
    public function it_errors_when_customer_has_no_address()
    {
        $customer = factory(User::class)->create();
        $this
            ->actingAs($customer, 'web')
            ->get(route('checkout.index'))
            ->assertOk()
            ->assertSee('No Address Is Found');
    }

    /** @test */
    public function it_errors_when_cart_is_empty()
    {
        $customer = factory(User::class)->create();
        $this->createAddressFor($customer);

        $this
            ->actingAs($customer, 'web')
            ->get(route('checkout.index'))
            ->assertSessionHas(['message' => 'Your Cart Is Empty']);
    }
    
    /** @test */
    public function it_errors_when_stock_quantities_are_not_avaliable()
    {
        $product = factory(Product::class)->create(['product_quantity' => 0]);
        $this->addToCart($product);

        $customer = factory(User::class)->create();
        $this->createAddressFor($customer);

        $this
            ->actingAs($customer, 'web')
            ->get(route('checkout.index'))
            ->assertSessionHas(['message' => 'Stock Quantities Are Not Enough For This Order']);
    }

    /** @test */
    public function it_shows_the_checkout_page()
    {
        $product = factory(Product::class)->create();
        $this->addToCart($product);

        $customer = factory(User::class)->create();
        $this->createAddressFor($customer);

        $this
            ->actingAs($customer, 'web')
            ->get(route('checkout.index'))
            ->assertOk()
            ->assertSee('Billing Address')
            ->assertSee('Shipping Address')
            ->assertSee($product->product_name)
            ->assertSee('Shipping Cost')
            ->assertSee('Courier')
            ->assertSee('Payment')
            ->assertSee('Total');
    }

    private function createAddressFor($customer) {        
        Country::insert([
            'id' => '226',
            'iso' => 'US',
            'name' => 'UNITED STATES OF AMERICA',
            'iso3' => 'USA',
            'numcode' => '840',
            'phonecode' => '1',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return factory(Address::class)->create(['user_id' => $customer->id]);
    }

    private function addToCart($product, $quantity = 1) {
        return $this->post(route('cart.store', [
            'product' => $product->id,
            'product_quantity' => $quantity
        ]));
    }

}
