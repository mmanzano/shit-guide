<?php

namespace GottaShit\Http\Controllers\Auth;

use GottaShit\Entities\User;
use GottaShit\Http\Controllers\Controller;
use GottaShit\Mailers\AppMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth as Auth;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['only' => ['register', 'postRegister']]);
    }

    /**
     * Show the register page.
     *
     * @param string $language
     * @return \Response
     */
    public function register(string $language)
    {
        $title = trans('gottashit.title.register');

        return view('auth.register', compact('title'));
    }

    /**
     * Perform the registration.
     *
     * @param Request $request
     * @param AppMailer $mailer
     * @param string $language
     * @return \Redirect
     */
    public function postRegister(Request $request, AppMailer $mailer, string $language)
    {
        $this->validate($request, [
            'full_name' => 'required|max:255',
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'full_name' => $request->input('full_name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'language' => App::getLocale(),
        ]);

        $mailer->sendEmailConfirmationTo($user, trans('gottashit.email.confirm_email_subject'));

        $statusMessage = trans('auth.confirm_email');

        $userLoginRoute = route('user_login', ['language' => App::getLocale()]);

        return redirect($userLoginRoute)->with('status', $statusMessage);
    }

    /**
     * Confirm a user's email address.
     *
     * @param string $language
     * @param string $token
     * @return mixed
     */
    public function confirmEmail(string $language, string $token)
    {
        User::where('token', $token)->firstOrFail()->confirmEmail();

        $statusMessage = trans('auth.confirmed');

        if (Auth::check()) {
            return redirect(route('root'));
        } else {
            $userLoginRoute = route('user_login', ['language' => App::getLocale()]);

            return redirect($userLoginRoute)
                ->with('status', $statusMessage);
        }
    }
}
