@props([
    'type' => 'text',
    'isError' => false,
    'label' => '',
    'name' => '',
    'value' => '',
])
<x-forms.label for="{{ $name }}">{{ $label }}</x-forms.label>
<input {{
    $attributes
        ->class([
            'border-red-600' => $isError,
            'block w-full border border-gray-300 px-4 py-3 text-gray-600 text-sm rounded focus:ring-0 focus:border-primary placeholder-gray-400'
        ])
    }}
    type="{{ $type }}"
    name="{{ $name }}"
   value="{{ $value }}"
/>
