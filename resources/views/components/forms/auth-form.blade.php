<div class="max-w-lg mx-auto shadow px-6 py-7 rounded overflow-hidden">
    <h2 class="text-2xl uppercase font-medium mb-1">
        {{ $title }}
    </h2>
    {{ $description }}
    <form method="{{ $method }}" action="{{ $action }}" autocomplete="off">
        {{ $slot }}
    </form>

    {{ $socialAuth }}

    {{ $buttons }}
</div>
