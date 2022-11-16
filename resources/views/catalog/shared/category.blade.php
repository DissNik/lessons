<div class="relative rounded-sm overflow-hidden group">
    <img src="{{ $item->makeThumbnail('500x312') }}" alt="{{ $item->title }}" class="w-full">
    <a href="{{ route('catalog', $item) }}"
       class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center text-xl text-white font-roboto font-medium group-hover:bg-opacity-60 transition">{{ $item->title }}</a>
</div>
