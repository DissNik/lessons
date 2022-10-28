<?php

use App\Models\Brand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');

            $table->string('thumbnail')
                ->nullable();

            $table->unsignedInteger('price')
                ->default(0);

            $table->foreignIdFor(Brand::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        // TODO 3rd lesson
        if (app()->isLocal()) {
            Schema::dropIfExists('products');
        }
    }
};
