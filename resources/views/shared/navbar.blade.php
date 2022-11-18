<nav class="bg-gray-800">
    <div class="container flex">
        <div class="px-8 py-4 bg-primary flex items-center cursor-pointer relative group">
                    <span class="text-white">
                        <i class="fa-solid fa-bars"></i>
                    </span>
            <span class="capitalize ml-2 text-white">All Categories</span>

            <!-- dropdown -->
            <div
                class="absolute w-full left-0 top-full bg-white shadow-md py-3 divide-y divide-gray-300 divide-dashed opacity-0 group-hover:opacity-100 transition duration-300 invisible group-hover:visible">
                <x-catalog-category-list></x-catalog-category-list>
            </div>
        </div>

        <div class="flex items-center justify-between flex-grow pl-12">
            <div class="flex items-center space-x-6 capitalize">
                @foreach($menu as $item)
                    <a href="{{ $item->link() }}"
                       class="@if($item->isActive()) text-white @else text-gray-200 @endif hover:text-white transition">{{ $item->label() }}</a>
                @endforeach
            </div>
            <div>
                @auth
                    <form
                        method="POST"
                        action="{{ route('logout') }}">
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="text-gray-200 hover:text-white transition"
                        >
                            Logout
                        </button>
                    </form>
                @elseguest
                    <a href="{{ route('login') }}" class="text-gray-200 hover:text-white transition">Login</a>
                    <span class="text-gray-200 hover:text-white transition">/</span>
                    <a href="{{ route('register') }}" class="text-gray-200 hover:text-white transition">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
