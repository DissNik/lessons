@extends('layouts.app')

@section('title', 'Create an account')

@section('content')
    <div class="contain py-16">
        <x-forms.auth-form
            title="Create an account"
            method="POST"
            action="{{ route('register') }}"
        >
            @csrf

            <x-slot:description>
                <p class="text-gray-600 mb-6 text-sm">
                    Register for new customer
                </p>
            </x-slot:description>

            <div class="space-y-2">
                <div>
                    <x-forms.text-input
                        label="Name"
                        name="name"
                        placeholder="Your name"
                        :isError="$errors->has('name')"
                        :value="old('name')"
                    >
                    </x-forms.text-input>
                    @error('name')
                    <x-forms.error>
                        {{ $message }}
                    </x-forms.error>
                    @enderror
                </div>

                <div>
                    <x-forms.text-input
                        type="email"
                        label="Email address"
                        name="email"
                        placeholder="youremail@domain.com"
                        :isError="$errors->has('email')"
                        :value="old('email')"
                    >
                    </x-forms.text-input>
                    @error('email')
                    <x-forms.error>
                        {{ $message }}
                    </x-forms.error>
                    @enderror
                </div>
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
            <div class="mt-4">
                <x-forms.primary-button
                    type="submit"
                >
                    Create account
                </x-forms.primary-button>
            </div>

            <x-slot:socialAuth>
                <x-forms.social-auth></x-forms.social-auth>
            </x-slot:socialAuth>

            <x-slot:buttons>
                <p class="mt-4 text-center text-gray-600">
                    Already have account?
                    <a href="{{ route('login') }}" class="text-primary">
                        Login now
                    </a>
                </p>
            </x-slot:buttons>
        </x-forms.auth-form>
    </div>
@endsection
