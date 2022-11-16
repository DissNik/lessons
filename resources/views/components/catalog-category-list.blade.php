@foreach($categories as $category)
    <a
        href="{{ route('catalog', $category) }}"
        class="flex items-center px-6 py-3 hover:bg-gray-100 transition"
    >
        @isset($category->icon)
            <img
                src="{{ $category->icon }}"
                alt="{{ $category->title }}"
                class="w-5 h-5 object-contain"
            >
        @endisset
        <span class="ml-6 text-gray-600 text-sm">{{ $category->title }}</span>
    </a>
@endforeach
