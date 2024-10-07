<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Mail\PlanExpirationReminder;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Foundation\Application;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return Application|Factory|View|\Illuminate\View\View
     */
    public function create(): \Illuminate\View\View
    {
        $registerImage = Setting::where('key', 'register_image')->value('value');

        return view('auth.login', ['registerImage' => $registerImage]);

    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Retrieve the user based on the provided email
        $user = User::whereEmail($request->email)->first();

        // Check if the user exists
        if (!empty($user)) {
            // Check if the user's email is verified
            if ($user['email_verified_at'] != null) {

                // Check if the user is active
                if ($user['is_active'] == User::IS_ACTIVE) {
                    // Attempt to authenticate the user with remember option
                    if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

                        $request->session()->regenerate(); // Regenerate the session to prevent session fixation attacks

                        return redirect()->intended(getDashboardURL());
                    } else {
                        // Authentication failed
                        throw ValidationException::withMessages([
                            'email' => __('auth.failed'),
                        ]);
                    }
                } else {
                    // User account is inactive
                    throw ValidationException::withMessages([
                        'email' => __('auth.account_deactivate'),
                    ]);
                }
            } else {
                // User's email is not verified
                throw ValidationException::withMessages([
                    'email' => __('auth.email_verify'),
                ]);
            }
        } else {
            // User does not exist
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
