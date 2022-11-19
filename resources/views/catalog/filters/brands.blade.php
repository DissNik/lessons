<div class="pt-4">
    <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">{{ $filter->title() }}</h3>
    <div class="space-y-2">
        @foreach($filter->values() as $brand)
            <div class="flex items-center">
                <input type="checkbox"
                       name="{{ $filter->name($brand->id) }}"
                       id="{{ $filter->id($brand->id) }}"
                       class="text-primary focus:ring-0 rounded-sm cursor-pointer"
                       value="{{ $brand->id }}"
                    @checked($filter->requestValue($brand->id))
                >
                <label for="{{ $filter->name($brand->id) }}"
                       class="text-gray-600 ml-3 cusror-pointer">{{ $brand->title }}</label>
                <div class="ml-auto text-gray-600 text-sm">({{ $brand->count }})</div>
            </div>
        @endforeach
    </div>
</div>
