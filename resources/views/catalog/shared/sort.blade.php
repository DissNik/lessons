<form x-ref="sortForm" action="{{ route('catalog', $category) }}">
    <select
        name="sort"
        x-on:change="$refs.sortForm.submit()"
        id="sort"
        class="w-44 text-sm text-gray-600 py-3 px-4 border-gray-300 shadow-sm rounded focus:ring-primary focus:border-primary">
        <option value="">Default sorting</option>
        @foreach($items as $item)
            @foreach($item->values() as $value => $label)
                <option
                    @selected(request('sort') === $value)
                    value="{{ $value }}"
                >
                    {{ $label }}
                </option>
            @endforeach
        @endforeach
    </select>
</form>
