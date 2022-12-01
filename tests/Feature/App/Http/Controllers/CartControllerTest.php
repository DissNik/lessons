<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CartController;
use Database\Factories\ProductFactory;
use Domain\Cart\CartManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        CartManager::fake();
    }

    public function test_is_empty_cart(): void
    {
        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items', collect([]));
    }

    public function test_is_not_empty_cart(): void
    {
        $product = ProductFactory::new()->createOne();

        cart()->add($product);

        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items', cart()->items());
    }

    public function test_added_success(): void
    {
        $product = ProductFactory::new()->createOne();

        $this->assertEquals(0, cart()->count());

        $this->post(action([CartController::class, 'add'], $product), [
            'quantity' => 4
        ]);

        $this->assertEquals(4, cart()->count());
    }

    public function test_quantity_changed(): void
    {
        $product = ProductFactory::new()->createOne();

        cart()->add($product, 4);

        $this->post(action([CartController::class, 'quantity'], cart()->items()->first()), [
            'quantity' => 2
        ]);

        $this->assertEquals(2, cart()->count());
    }

    public function test_delete_success(): void
    {
        $product = ProductFactory::new()->createOne();

        cart()->add($product, 4);

        $this->delete(
            action([CartController::class, 'delete'], cart()->items()->first())
        );

        $this->assertEquals(0, cart()->count());
    }

    public function test_truncate_success(): void
    {
        $product = ProductFactory::new()->createOne();

        cart()->add($product, 4);

        $this->delete(
            action([CartController::class, 'truncate'])
        );

        $this->assertEquals(0, cart()->count());
    }
}
