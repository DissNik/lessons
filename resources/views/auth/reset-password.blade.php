@extends('layouts.app')

@section('title', 'Reset password')

@section('content')
    <div class="contain py-16">
        <x-forms.auth-form
            title="Reset password"
            method="POST"
            action="{{ route('password.update') }}"
        >
            @csrf

            <x-slot:description>
            </x-slot:description>

            <input type="hidden" name="token" value="{{ $token }}" />

            <div class="space-y-2">
                <div>
                    <x-forms.text-input
                        type="email"
                        label="Email address"
                        name="email"
                        placeholder="youremail@domain.com"
                        :isError="$errors->has('email')"
                        :value="request('email')"
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
                    Save password
                </x-forms.primary-button>
            </div>

            <x-slot:socialAuth>
            </x-slot:socialAuth>

            <x-slot:buttons>
            </x-slot:buttons>
        </x-forms.auth-form>
    </div>
@endsection
