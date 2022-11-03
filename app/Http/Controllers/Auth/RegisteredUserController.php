<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpFormRequest;
use Domain\Customer\Contracts\RegisterUserContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegisteredUserController extends Controller
{
    public function create(): Factory|View|Application
    {
        return view('auth.sign-up');
    }

    public function store(SignUpFormRequest $request, RegisterUserContract $action): RedirectResponse
    {
        //TODO make DTOs

        $action(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );

        return redirect()
            ->intended(route('home'));
    }
}
