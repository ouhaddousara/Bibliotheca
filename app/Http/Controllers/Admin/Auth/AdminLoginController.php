<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminLoginController extends Controller
{
    /**
     * Display the admin login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle admin login attempt
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            // Regenerate session to prevent fixation attacks
            $request->session()->regenerate();

            // Log successful login
            Log::channel('library')->info('Admin connecté', [
                'admin_id' => Auth::guard('admin')->id(),
                'admin_email' => Auth::guard('admin')->user()->email,
                'ip_address' => $request->ip(),
            ]);

            // Redirect to admin dashboard
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', '✅ Bonjour ! Bienvenue dans l\'espace administrateur.');
        }

        // Log failed login attempt
        Log::channel('library')->warning('Tentative de connexion échouée', [
            'email' => $request->email,
            'ip_address' => $request->ip(),
        ]);

        // Return back with error
        return back()
            ->withErrors([
                'email' => __('auth.failed'),
            ])
            ->withInput($request->only('email', 'remember'));
    }

    /**
     * Handle admin logout
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $adminEmail = Auth::guard('admin')->user()->email ?? 'N/A';

        // Log logout
        Log::channel('library')->info('Admin déconnecté', [
            'admin_id' => Auth::guard('admin')->id(),
            'admin_email' => $adminEmail,
            'ip_address' => $request->ip(),
        ]);

        // Logout
        Auth::guard('admin')->logout();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login with success message
        return redirect()->route('admin.login')
            ->with('success', '👋 Déconnexion réussie ! À bientôt.');
    }
}