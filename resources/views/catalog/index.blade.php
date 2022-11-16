@extends('layouts.app')

@section('title', 'Catalog')

@section('content')
    <div class="container py-4 flex items-center gap-3">
        <a href="{{ route('home') }}" class="text-primary text-base">
            <i class="fa-solid fa-house"></i>
        </a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        <a href="{{ route('catalog') }}" class="text-primary text-base">
            Shop
        </a>
        @if($category->exists)
            <span class="text-sm text-gray-400">
                <i class="fa-solid fa-chevron-right"></i>
            </span>
            <p class="text-gray-600 font-medium">{{ $category->title }}</p>
        @endif
    </div>

    <div class="container grid grid-cols-4 gap-6 pt-4 pb-16 items-start">

        <!-- sidebar -->
        <div class="col-span-1 bg-white px-4 pb-6 shadow rounded overflow-hidden">
            <form action="{{ route('catalog', $category) }}" class="divide-y divide-gray-200 space-y-5">
                <div class="pt-4">
                    <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Price</h3>
                    <div class="mt-4 flex items-center">
                        <input type="text" name="filters[price][from]" id="min"
                               value="{{ request('filters.price.from', 0) }}"
                               class="w-full border-gray-300 focus:border-primary rounded focus:ring-0 px-3 py-1 text-gray-600 shadow-sm"
                               placeholder="min">
                        <span class="mx-3 text-gray-500">-</span>
                        <input type="text" name="filters[price][to]" id="max"
                               value="{{ request('filters.price.to', 100000) }}"
                               class="w-full border-gray-300 focus:border-primary rounded focus:ring-0 px-3 py-1 text-gray-600 shadow-sm"
                               placeholder="max">
                    </div>
                </div>
                <div class="pt-4">
                    <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Brands</h3>
                    <div class="space-y-2">
                        @foreach($brands as $brand)
                            <div class="flex items-center">
                                <input type="checkbox" name="filters[brands][{{ $brand->id }}]"
                                       id="brand-{{ $brand->id }}"
                                       class="text-primary focus:ring-0 rounded-sm cursor-pointer"
                                       value="{{ $brand->id }}"
                                    @checked(request('filters.brands.' . $brand->id))
                                >
                                <label for="brand-{{ $brand->id }}"
                                       class="text-gray-600 ml-3 cusror-pointer">{{ $brand->title }}</label>
                                <div class="ml-auto text-gray-600 text-sm">(15)</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="pt-4">
                    <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">size</h3>
                    <div class="flex items-center gap-2">
                        <div class="size-selector">
                            <input type="radio" name="size" id="size-xs" class="hidden">
                            <label for="size-xs"
                                   class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">XS</label>
                        </div>
                        <div class="size-selector">
                            <input type="radio" name="size" id="size-sm" class="hidden">
                            <label for="size-sm"
                                   class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">S</label>
                        </div>
                        <div class="size-selector">
                            <input type="radio" name="size" id="size-m" class="hidden">
                            <label for="size-m"
                                   class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">M</label>
                        </div>
                        <div class="size-selector">
                            <input type="radio" name="size" id="size-l" class="hidden">
                            <label for="size-l"
                                   class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">L</label>
                        </div>
                        <div class="size-selector">
                            <input type="radio" name="size" id="size-xl" class="hidden">
                            <label for="size-xl"
                                   class="text-xs border border-gray-200 rounded-sm h-6 w-6 flex items-center justify-center cursor-pointer shadow-sm text-gray-600">XL</label>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">Color</h3>
                    <div class="flex items-center gap-2">
                        <div class="color-selector">
                            <input type="radio" name="color" id="red" class="hidden">
                            <label for="red"
                                   class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"
                                   style="background-color: #fc3d57;"></label>
                        </div>
                        <div class="color-selector">
                            <input type="radio" name="color" id="black" class="hidden">
                            <label for="black"
                                   class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"
                                   style="background-color: #000;"></label>
                        </div>
                        <div class="color-selector">
                            <input type="radio" name="color" id="white" class="hidden">
                            <label for="white"
                                   class="border border-gray-200 rounded-sm h-6 w-6  cursor-pointer shadow-sm block"
                                   style="background-color: #fff;"></label>
                        </div>

                    </div>
                </div>

                <div class="pt-4 text-center">
                    <x-forms.primary-button type="submit">Поиск</x-forms.primary-button>
                    @if (request('filters'))
                        <a
                            class="text-xs inline-block pt-2 text-gray-400 hover:text-primary"
                            href="{{ route('catalog', $category) }}"
                        >
                            Сбросить фильтр
                        </a>
                    @endif
                </div>
            </form>
        </div>
        <!-- ./sidebar -->

        <!-- products -->
        <div class="col-span-3">
            <div x-data="{}" class="flex items-center mb-4">
                <form x-ref="sortForm" action="{{ route('catalog', $category) }}">
                    <select
                        name="sort"
                        x-on:change="$refs.sortForm.submit()"
                        id="sort"
                        class="w-44 text-sm text-gray-600 py-3 px-4 border-gray-300 shadow-sm rounded focus:ring-primary focus:border-primary">
                        <option value="">Default sorting</option>
                        <option @selected(request('sort') === 'price') value="price">Price low to high</option>
                        <option @selected(request('sort') === '-price') value="-price">Price high to low</option>
                        <option @selected(request('sort') === 'title') value="title">Name product</option>
                    </select>
                </form>

                <div class="flex gap-2 ml-auto">
                    <div
                        class="border border-primary w-10 h-9 flex items-center justify-center text-white bg-primary rounded cursor-pointer">
                        <i class="fa-solid fa-grip-vertical"></i>
                    </div>
                    <div
                        class="border border-gray-300 w-10 h-9 flex items-center justify-center text-gray-600 rounded cursor-pointer">
                        <i class="fa-solid fa-list"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6">
                @each('catalog.shared.product', $products, 'item')
            </div>

            <div class="mt-12">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
        <!-- ./products -->
    </div>
@endsection
