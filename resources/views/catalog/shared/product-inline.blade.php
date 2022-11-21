<div class="flex items-center justify-between border gap-6 p-4 border-gray-200 rounded">
    <div class="w-28">
        <div class="relative">
            <img src="{{ $item->makeThumbnail('400x297') }}" alt="{{ $item->title }}" class="w-full">
            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center
                    justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                <a href="#"
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
    </div>
    <div class="w-1/3">
        <h2 class="text-gray-800 text-xl font-medium uppercase">{{ $item->title }}</h2>
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
        <p class="text-sm text-gray-400 line-through">55.90</p>
    </div>
    <a href="#"
       class="px-6 py-2 text-center text-sm text-white bg-primary border border-primary rounded hover:bg-transparent hover:text-primary transition uppercase font-roboto font-medium">add
        to cart</a>
</div>
