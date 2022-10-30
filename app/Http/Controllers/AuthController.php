<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPassportFormRequest;
use App\Http\Requests\ResetPassportFormRequest;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Models\User;
use http\Client\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function index(): Factory|View|Application
    {
        return view('auth.index');
    }

    public function signIn(SignInFormRequest $request): RedirectResponse
    {
        // TODO 3rd lesson rate limit

        if (!auth()->attempt($request->validated())) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()
            ->intended(route('home'));
    }

    public function signUp(): Factory|View|Application
    {
        return view('auth.sign-up');
    }

    public function store(SignUpFormRequest $request): RedirectResponse
    {
        $user = User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()
            ->intended(route('home'));
    }

    public function forgot(): Factory|View|Application
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(ForgotPassportFormRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // TODO 3rd lesson Flash

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['message' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function reset(string $token): Factory|View|Application
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(ResetPassportFormRequest $request): RedirectResponse
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(str()->random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('message', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logOut(): RedirectResponse
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()
            ->intended(route('home'));
    }

}
