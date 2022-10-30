@extends('layouts.app')

@section('title', 'Forgot password')

@section('content')
    <div class="contain py-16">
        <x-forms.auth-form
            title="Forgot password"
            method="POST"
            action="{{ route('password.email') }}"
        >
            @csrf

            <x-slot:description>
            </x-slot:description>

            <div class="space-y-2">
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
            </div>
            <div class="mt-4">
                <x-forms.primary-button
                    type="submit"
                >
                    Send
                </x-forms.primary-button>
            </div>

            <x-slot:socialAuth>
            </x-slot:socialAuth>

            <x-slot:buttons>
                <p class="mt-4 text-center text-gray-600">
                    Did remember the password?
                    <a href="{{ route('login') }}" class="text-primary">
                        Login now
                    </a>
                </p>
            </x-slot:buttons>
        </x-forms.auth-form>
    </div>
@endsection
