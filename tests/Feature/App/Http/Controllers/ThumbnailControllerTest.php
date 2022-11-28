<?php

namespace Tests\Feature\App\Http\Controllers;

use Database\Factories\ProductFactory;
use Domain\Product\Models\Product;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    protected Product $product;
    protected Filesystem $storage;
    protected string $size;

    protected function setUp(): void
    {
        parent::setUp();

        $this->size = '200x200';

        config()->set('thumbnail', ['allowed_sizes' => [$this->size]]);

        $this->storage = Storage::disk('images');
        $this->product = ProductFactory::new()->create();
    }

    public function test_resize_success(): void
    {
        $method = 'resize';

        $this->get($this->product->makeThumbnail($this->size, $method))
            ->assertOk();

        $this->storage->assertExists(
            "products/$method/$this->size/" . File::basename($this->product->thumbnail)
        );
    }

    public function test_crop_success(): void
    {
        $method = 'crop';

        $this->get($this->product->makeThumbnail($this->size, $method))
            ->assertOk();

        $this->storage->assertExists(
            "products/$method/$this->size/" . File::basename($this->product->thumbnail)
        );
    }

    public function test_fit_success(): void
    {
        $method = 'fit';

        $this->get($this->product->makeThumbnail($this->size, $method))
            ->assertOk();

        $this->storage->assertExists(
            "products/$method/$this->size/" . File::basename($this->product->thumbnail)
        );
    }

    public function test_fail_by_error_size(): void
    {
        $this->get($this->product->makeThumbnail('0x0'))
            ->assertStatus(403)
            ->assertSee('Size not allowed');
    }

    public function test_fail_by_error_method(): void
    {
        $this->get($this->product->makeThumbnail($this->size, 'test'))
            ->assertStatus(404);
    }
}
