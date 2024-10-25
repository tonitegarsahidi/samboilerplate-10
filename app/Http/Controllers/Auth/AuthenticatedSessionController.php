<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AlertHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * =============================================
     * Display the login view.
     * =============================================
     */
    public function create(): View
    {
        $alerts = AlertHelper::getAlerts();
        return view('admin.auth.login', compact('alerts'));
    }

    /**
     * =============================================
     * Handle an incoming authentication request.
     * =============================================
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * =============================================
     * Destroy an authenticated session.
     * a.k.a Logout
     * =============================================
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
