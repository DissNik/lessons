<header class="py-4 shadow-sm bg-white">
    <div class="container flex items-center justify-between">
        <a href="{{ route('home') }}">
            <img src="{{ Vite::image('logo.svg') }}" alt="Logo" class="w-32">
        </a>

        <form
            action="{{ route('catalog') }}"
            class="w-full max-w-xl relative flex"
        >
            <span class="absolute left-4 top-3 text-lg text-gray-400">
                <i class="fa-solid fa-magnifying-glass"></i>
            </span>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                id="search"
                class="w-full border border-primary border-r-0 pl-12 py-3 pr-3 rounded-l-md focus:outline-none"
                placeholder="search"
            >
            <button
                type="submit"
                class="bg-primary border border-primary text-white px-8 rounded-r-md hover:bg-transparent hover:text-primary transition"
            >
                Search
            </button>
        </form>

        <div class="flex items-center space-x-4">
            <a href="#" class="text-center text-gray-700 hover:text-primary transition relative">
                <div class="text-2xl">
                    <i class="fa-regular fa-heart"></i>
                </div>
                <div class="text-xs leading-3">Wishlist</div>
                <div
                    class="absolute right-0 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-primary text-white text-xs">
                    8
                </div>
            </a>
            <a href="#" class="text-center text-gray-700 hover:text-primary transition relative">
                <div class="text-2xl">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
                <div class="text-xs leading-3">Cart</div>
                <div
                    class="absolute -right-3 -top-1 w-5 h-5 rounded-full flex items-center justify-center bg-primary text-white text-xs">
                    2
                </div>
            </a>
            @auth
                <a href="#" class="text-center text-gray-700 hover:text-primary transition relative">
                    <img class="inline rounded-full max-w-none" src="{{ auth()->user()->avatar }}">
                    <div class="text-xs leading-3">Account</div>
                </a>
            @elseguest
                <a href="{{ route('login') }}" class="text-center text-gray-700 hover:text-primary transition relative">
                    <div class="text-2xl">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="text-xs leading-3">Account</div>
                </a>
            @endauth
        </div>
    </div>
</header>
