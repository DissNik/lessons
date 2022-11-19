<div class="pt-4">
    <h3 class="text-xl text-gray-800 mb-3 uppercase font-medium">{{ $filter->title() }}</h3>
    <div class="mt-4 flex items-center">
        <input type="text"
               name="{{ $filter->name('from') }}"
               id="{{ $filter->id('from') }}"
               value="{{ $filter->requestValue('from', 0) }}"
               class="w-full border-gray-300 focus:border-primary rounded focus:ring-0 px-3 py-1 text-gray-600 shadow-sm"
               placeholder="min">
        <span class="mx-3 text-gray-500">-</span>
        <input type="text"
               name="{{ $filter->name('to') }}"
               id="{{ $filter->id('to') }}"
               value="{{ $filter->requestValue('to', 100000) }}"
               class="w-full border-gray-300 focus:border-primary rounded focus:ring-0 px-3 py-1 text-gray-600 shadow-sm"
               placeholder="max">
    </div>
</div>
