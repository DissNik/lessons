@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="contain py-16">
        <x-forms.auth-form
            title="Login"
            method="POST"
            action="{{ route('signIn') }}"
        >
            @csrf

            <x-slot:description>
                <p class="text-gray-600 mb-6 text-sm">
                    welcome back customer
                </p>
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
            </div>
            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                           class="text-primary focus:ring-0 rounded-sm cursor-pointer">
                    <label for="remember" class="text-gray-600 ml-3 cursor-pointer">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-primary">Forgot password</a>
            </div>
            <div class="mt-4">
                <x-forms.primary-button
                    type="submit"
                >
                    Login
                </x-forms.primary-button>
            </div>

            <x-slot:socialAuth>
                <x-forms.social-auth></x-forms.social-auth>
            </x-slot:socialAuth>

            <x-slot:buttons>
                <p class="mt-4 text-center text-gray-600">
                    Don't have account?
                    <a href="{{ route('signUp') }}" class="text-primary">
                        Register now
                    </a>
                </p>
            </x-slot:buttons>
        </x-forms.auth-form>
    </div>
@endsection
