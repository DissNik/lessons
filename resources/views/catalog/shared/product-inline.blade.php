<div class="flex items-center justify-between border gap-6 p-4 border-gray-200 rounded">
    <div class="w-28">
        <div class="relative">
            <a href="{{ route('product', $item) }}" title="view product">
                <img src="{{ $item->makeThumbnail('400x297') }}" alt="{{ $item->title }}" class="w-full">
            </a>
        </div>
    </div>
    <div class="w-1/3">
        <a href="{{ route('product', $item) }}" title="view product">
            <h2 class="text-gray-800 text-xl font-medium uppercase">{{ $item->title }}</h2>
        </a>
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
    <div class="flex items-baseline mb-1 space-x-2">
        <p class="text-xl text-primary font-semibold">{{ $item->price }}</p>
        @if($item->old_price)
            <p class="text-sm text-gray-400 line-through">{{ $item->old_price }}</p>
        @endif
    </div>
    <a href="#"
       class="px-6 py-2 text-center text-sm text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium">add
        to cart</a>
</div>
