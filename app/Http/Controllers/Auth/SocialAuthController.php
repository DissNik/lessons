<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Customer\Models\User;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Support\SessionRegenerator;
use Throwable;

class SocialAuthController extends Controller
{

    public function redirect(string $driver): \Symfony\Component\HttpFoundation\RedirectResponse|RedirectResponse
    {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (Throwable $e) {
            throw new DomainException('Произошла ошибка или драйвер не поддерживается');
        }
    }

    public function callback(string $driver): RedirectResponse
    {
        if ($driver != 'github') {
            throw new DomainException('Драйвер не поддерживается');
        }

        $githubUser = Socialite::driver($driver)->user();

        $user = User::query()
            ->updateOrCreate([
                $driver . '_id' => $githubUser->getId(),
            ], [
                'name' => $githubUser->getName() ?? $githubUser->getEmail(),
                'email' => $githubUser->getEmail(),
                'password' => Hash::make(str()->random(20)),
            ]);

        SessionRegenerator::run(fn() => auth()->login($user));

        return redirect()
            ->intended(route('home'));
    }
}
