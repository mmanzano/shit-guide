<?php

namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Services\SocialiteGottaShit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToProvider(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(SocialiteGottaShit $socialiteGottaShit, string $provider): RedirectResponse
    {
        $socialiteUser = Socialite::driver($provider)->user();

        Auth::login($socialiteGottaShit->getAuthUser($socialiteUser, $provider), true);

        return redirect(route('user.show', ['user' => Auth::id()]));
    }
}
