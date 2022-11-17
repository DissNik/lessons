<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\ThumbnailController;
use Database\Factories\ProductFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    use RefreshDatabase;

    protected string $filePath;
    protected string $allowedSize;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('image');

        $this->filePath = File::basename(ProductFactory::new()->create()->thumbnail);

        $this->allowedSize = config('thumbnail.allowed_sizes.0');
    }

    public function test_resize_success(): void
    {
        $this->get(action(ThumbnailController::class, [
            'size' => $this->allowedSize,
            'dir' => 'products',
            'method' => 'resize',
            'file' => $this->filePath
        ]))
            ->assertOk();
    }

    public function test_crop_success(): void
    {
        $this->get(action(ThumbnailController::class, [
            'size' => $this->allowedSize,
            'dir' => 'products',
            'method' => 'crop',
            'file' => $this->filePath
        ]))
            ->assertOk();
    }

    public function test_fit_success(): void
    {
        $this->get(action(ThumbnailController::class, [
            'size' => $this->allowedSize,
            'dir' => 'products',
            'method' => 'fit',
            'file' => $this->filePath
        ]))
            ->assertOk();
    }

    public function test_fail_by_error_size(): void
    {
        $this->get(action(ThumbnailController::class, [
            'size' => '0x0',
            'dir' => 'products',
            'method' => 'resize',
            'file' => $this->filePath
        ]))
            ->assertStatus(403)
            ->assertSee('Size not allowed');
    }

    public function test_fail_by_error_method(): void
    {
        $this->get(action(ThumbnailController::class, [
            'size' => $this->allowedSize,
            'dir' => 'products',
            'method' => 'test',
            'file' => $this->filePath
        ]))
            ->assertStatus(404);
    }
}
