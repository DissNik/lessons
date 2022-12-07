@extends('layouts.app')

@section('title', 'Catalog')

@section('content')
    <div class="container py-4 flex items-center gap-3">
        <a href="{{ route('home') }}" class="text-primary text-base">
            <i class="fa-solid fa-house"></i>
        </a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        <a href="{{ route('cart') }}" class="text-primary text-base">Корзина</a>
        <span class="text-sm text-gray-400">
            <i class="fa-solid fa-chevron-right"></i>
        </span>
        <p class="text-gray-600 font-medium">Оформление заказа</p>
    </div>
    <form action="{{ route('order.store') }}" method="POST">
        @csrf

        <div class="container grid grid-cols-12 items-start pb-16 pt-4 gap-6">
            <div class="col-span-4 border border-gray-200 p-4 rounded">
                <h3 class="text-lg font-medium capitalize mb-4">CONTACT INFORMATION</h3>
                <div class="space-y-4">
                    <div>
                        <x-forms.text-input
                            label="First Name"
                            name="customer[first_name]"
                            placeholder="Your first Name"
                            :isError="$errors->has('customer.first_name')"
                            :value="old('customer.first_name')"
                        >
                        </x-forms.text-input>
                        @error('customer.first_name')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                        @enderror
                    </div>
                    <div>
                        <x-forms.text-input
                            label="Last Name"
                            name="customer[last_name]"
                            placeholder="Your last Name"
                            :isError="$errors->has('customer.last_name')"
                            :value="old('customer.last_name')"
                        >
                        </x-forms.text-input>
                        @error('customer.last_name')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                        @enderror
                    </div>
                    <div>
                        <x-forms.text-input
                            label="Phone number"
                            name="customer[phone]"
                            placeholder="Only digit"
                            :isError="$errors->has('customer.phone')"
                            :value="old('customer.phone')"
                        >
                        </x-forms.text-input>
                        @error('customer.phone')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                        @enderror
                    </div>
                    <div>
                        <x-forms.text-input
                            label="Email address"
                            name="customer[email]"
                            placeholder=""
                            :isError="$errors->has('customer.email')"
                            :value="old('customer.email')"
                        >
                        </x-forms.text-input>
                        @error('customer.email')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                        @enderror
                    </div>
                    @guest()
                        <div x-data="{ createAccount: false }">
                            <input
                                type="checkbox"
                                name="create_account"
                                id="checkout-create-account"
                                value="1"
                                @checked(old('create_account'))
                                @click="createAccount = ! createAccount"
                                class="text-primary focus:ring-0 rounded-sm cursor-pointer w-3 h-3"
                            >
                            <label
                                for="checkout-create-account"
                                class="text-gray-600 ml-3 cursor-pointer"
                            >
                                Create account
                            </label>
                            <div
                                x-show="createAccount"
                                x-transition:enter="ease-out duration-300"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-out duration-300"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="mt-3 space-y-4"
                            >
                                <div>
                                    <x-forms.text-input
                                        type="password"
                                        label="Password"
                                        name="password"
                                        placeholder="*******"
                                        :isError="$errors->has('password')"
                                    >
                                    </x-forms.text-input>
                                    @error('password')
                                    <x-forms.error>
                                        {{ $message }}
                                    </x-forms.error>
                                    @enderror
                                </div>
                                <div>
                                    <x-forms.text-input
                                        type="password"
                                        label="Password confirmation"
                                        name="password_confirmation"
                                        placeholder="*******"
                                        :isError="$errors->has('password_confirmation')"
                                    >
                                    </x-forms.text-input>
                                    @error('password_confirmation')
                                    <x-forms.error>
                                        {{ $message }}
                                    </x-forms.error>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
            <div
                class="col-span-4 border border-gray-200 p-4 rounded"
                x-data="{ withAddress: {{ $deliveries->first()->with_address ?? false }} }"
            >
                <h3 class="text-lg font-medium capitalize mb-4">DELIVERY</h3>
                @foreach($deliveries as $delivery)
                    <div>
                        <input
                            type="radio"
                            name="delivery_type_id"
                            id="delivery-type-{{ $delivery->id }}"
                            value="{{ $delivery->id }}"
                            @checked($loop->first || old('delivery_type_id') == $delivery->id)
                            class="text-primary focus:ring-0 cursor-pointer w-3 h-3"
                            @click=@if($delivery->with_address) "withAddress = true" @else
                            "withAddress = false"
                        @endif
                        >
                        <label
                            for="delivery-type-{{ $delivery->id }}"
                            class="text-gray-600 ml-3 cursor-pointer"
                        >
                            {{ $delivery->title }}
                        </label>
                    </div>
                @endforeach
                <div class="space-y-4 mt-3"
                     x-show="withAddress"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-out duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                >
                    <div>
                        <x-forms.text-input
                            type="text"
                            label="City"
                            name="customer[city]"
                            :isError="$errors->has('customer.city')"
                        >
                        </x-forms.text-input>
                        @error('customer.city')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                        @enderror
                    </div>
                    <div>
                        <x-forms.text-input
                            type="text"
                            label="Address"
                            name="customer[address]"
                            :isError="$errors->has('customer.address')"
                        >
                        </x-forms.text-input>
                        @error('customer.address')
                        <x-forms.error>
                            {{ $message }}
                        </x-forms.error>
                        @enderror
                    </div>
                </div>
                <h3 class="text-lg font-medium capitalize my-4">PAYMENT</h3>
                @foreach($payments as $payment)
                    <div>
                        <input
                            type="radio"
                            name="payment_method_id"
                            id="payment-method-{{ $payment->id }}"
                            value="{{ $payment->id }}"
                            @checked($loop->first || old('delivery_type_id') == $payment->id)
                            class="text-primary focus:ring-0 cursor-pointer w-3 h-3"
                        >
                        <label
                            for="payment-method-{{ $payment->id }}"
                            class="text-gray-600 ml-3 cursor-pointer"
                        >
                            {{ $payment->title }}
                        </label>
                    </div>
                @endforeach
            </div>
            <div class="col-span-4 border border-gray-200 p-4 rounded">
                <h4 class="text-gray-800 text-lg mb-4 font-medium uppercase">order summary</h4>
                <div class="space-y-2">
                    @foreach($items as $item)
                        <div class="flex justify-between">
                            <div class="min-w-[50%]">
                                <h5 class="text-gray-800 font-medium">{{ $item->product->title }}</h5>
                                @if($item->optionValues->isNotEmpty())
                                    <table class="table-auto w-full text-left text-gray-600 text-xs">
                                        @foreach($item->optionValues as $value)
                                            <tr>
                                                <th class="px-4w-40 font-medium">{{ $value->option->title }}</th>
                                                <th class="px-4">{{ $value->title }}</th>
                                            </tr>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                            <p class="text-gray-600">
                                x{{ $item->quantity }}
                            </p>
                            <p class="text-gray-800 font-medium">{{ $item->amount }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                    <p>subtotal</p>
                    <p>{{ cart()->amount() }}</p>
                </div>

                <div class="flex justify-between border-b border-gray-200 mt-1 text-gray-800 font-medium py-3 uppercas">
                    <p>shipping</p>
                    <p>Free</p>
                </div>

                <div class="flex justify-between text-gray-800 font-medium py-3 uppercas">
                    <p class="font-semibold">Total</p>
                    <p>{{ cart()->amount() }}</p>
                </div>

                <div class="flex items-center mb-4 mt-2">
                    <input type="checkbox" name="aggrement" id="aggrement"
                           class="text-primary focus:ring-0 rounded-sm cursor-pointer w-3 h-3">
                    <label for="aggrement" class="text-gray-600 ml-3 cursor-pointer text-sm">I agree to the <a href="#"
                                                                                                               class="text-primary">terms
                            & conditions</a></label>
                </div>

                <button
                    type="submit"
                    class="block w-full py-3 px-4 text-center text-white bg-primary border border-primary rounded-md hover:bg-transparent hover:text-primary transition font-medium"
                >
                    Place order
                </button>
            </div>
        </div>
    </form>
@endsection
