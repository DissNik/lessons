<div class="bg-white shadow rounded overflow-hidden group">
    <div class="relative">
        <img src="{{ $item->makeThumbnail('400x297') }}" alt="{{ $item->title }}" class="w-full">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center
                    justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
            <a href="{{ route('product', $item) }}"
               class="text-white text-lg w-9 h-8 rounded-full bg-primary flex items-center justify-center hover:bg-gray-800 transition"
               title="view product">
                <i class="fa-solid fa-magnifying-glass"></i>
            </a>
            <a href="#"
               class="text-white text-lg w-9 h-8 rounded-full bg-primary flex items-center justify-center hover:bg-gray-800 transition"
               title="add to wishlist">
                <i class="fa-solid fa-heart"></i>
            </a>
        </div>
    </div>
    <div class="pt-4 pb-3 px-4">
        <a href="{{ route('product', $item) }}">
            <h4 class="uppercase font-medium text-xl mb-2 text-gray-800 hover:text-primary transition">
                {{ $item->title }}
            </h4>
        </a>
        <div class="flex items-baseline mb-1 space-x-2">
            <p class="text-xl text-primary font-semibold">{{ $item->price }}</p>
            @if($item->old_price)
                <p class="text-sm text-gray-400 line-through">{{ $item->old_price }}</p>
            @endif
        </div>
        <div class="flex items-center">
            <div class="flex gap-1 text-sm text-yellow-400">
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
                <span><i class="fa-solid fa-star"></i></span>
            </div>
            <div class="text-xs text-gray-500 ml-3">(150)</div>
        </div>
    </div>
    <form action="{{ route('cart.add', $item) }}" method="POST">
        @csrf
        <button type="submit"
                class="block w-full py-1 text-center text-white bg-primary border border-primary rounded-b hover:bg-transparent hover:text-primary transition">
            Add
            to cart
        </button>
    </form>
</div>
