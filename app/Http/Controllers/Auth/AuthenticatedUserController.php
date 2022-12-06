<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInFormRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Support\SessionRegenerator;

class AuthenticatedUserController extends Controller
{
    public function create(): Factory|View|Application
    {
        return view('auth.login');
    }

    public function store(SignInFormRequest $request): RedirectResponse
    {
        if (!auth()->once($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        SessionRegenerator::run(fn() => auth()->login(auth()->user()));

        return redirect()
            ->intended(route('home'));
    }

    public function destroy(): RedirectResponse
    {
        SessionRegenerator::run(fn() => auth()->logout());

        return redirect()
            ->intended(route('home'));
    }
}
