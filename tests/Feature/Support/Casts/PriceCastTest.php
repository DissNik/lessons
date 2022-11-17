<?php

namespace Tests\Feature\Support\Casts;


use App\Models\Product;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Support\ValueObjects\Price;
use Tests\TestCase;

class PriceCastTest extends TestCase
{
    use RefreshDatabase;

    protected Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = ProductFactory::new()->make();
    }


    public function test_success_get_price(): void
    {
        $this->assertInstanceOf(Price::class, $this->product->price);
    }

    public function test_success_set_price(): void
    {
        $this->product->price = Price::make(10000);

        $this->assertInstanceOf(Price::class, $this->product->price);
    }

    public function test_success_set_raw_price(): void
    {
        $this->product->price = 10000;

        $this->assertInstanceOf(Price::class, $this->product->price);
    }

    public function test_fail_set_raw_price(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->product->price = -10000;
    }
}
