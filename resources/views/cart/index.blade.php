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
        <p class="text-gray-600 font-medium">Корзина</p>
    </div>
    <div class="container space-y-4">
        @if($items->isEmpty())
            <div class="py-3 px-6 rounded-lg bg-gray-800 text-white">Корзина пуста</div>
        @else
            @foreach($items as $item)
                <div class="flex items-center justify-between border gap-6 p-4 border-gray-200 rounded">
                    <div class="w-28">
                        <img src="{{ $item->product->makeThumbnail('400x297') }}" alt="{{ $item->product->title }}"
                             class="w-full">
                    </div>
                    <div class="w-1/3">
                        <h2 class="text-gray-800 text-xl font-medium uppercase">{{ $item->product->title }}</h2>
                        <p class="text-gray-500 text-sm">Availability: <span class="text-green-600">In Stock</span></p>

                        @if($item->optionValues->isNotEmpty())
                            <table class="table-auto w-full text-left text-gray-600 text-xs mt-6 mb-6">
                                @foreach($item->optionValues as $value)
                                    <tr>
                                        <th class="px-4w-40 font-medium">{{ $value->option->title }}</th>
                                        <th class="px-4">{{ $value->title }}</th>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
                    <div class="text-primary text-lg font-semibold">{{ $item->price }}</div>

                    <form method="POST" action="{{ route('cart.quantity', $item) }}">
                        @csrf
                        <div class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 w-max">

                            <button type="button"
                                    class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none">
                                -
                            </button>
                            <div class="h-8 w-8 text-base flex items-center justify-center">
                                <input type="text" class="flex border-0 p-0 text-center w-full" name="quantity"
                                       value="{{ $item->quantity }}">
                            </div>
                            <button type="button"
                                    class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer select-none">
                                +
                            </button>
                        </div>
                    </form>

                    <div class="text-primary text-lg font-semibold">{{ $item->amount }}</div>

                    <form method="POST" action="{{ route('cart.delete', $item) }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="text-gray-600 cursor-pointer hover:text-primary">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            @endforeach
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mt-8">
                <div class="text-[32px] font-black">Итого: {{ cart()->amount() }}</div>
                <form action="{{ route('cart.truncate') }}" method="POST" class="pb-3 lg:pb-0">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"

                    >
                        Очистить корзину
                    </button>
                </form>
                <div class="flex items-center flex-col sm:flex-row lg:justify-end gap-4">
                    <a
                        href="{{ route('catalog') }}"
                    >За покупками</a>
                    <a href="#"
                       class="px-6 py-2 text-center text-sm text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium">Оформить
                        заказ</a>
                </div>
            </div>
        @endif
    </div>
@endsection
