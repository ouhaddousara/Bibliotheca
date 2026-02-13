<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClientLoginController extends Controller
{
    /**
     * Display the client login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    /**
     * Handle client login attempt
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        // Check if member is active
        $member = \App\Models\Member::where('email', $request->email)->first();
        
        if ($member && !$member->is_active) {
            Log::channel('library')->warning('Tentative de connexion membre désactivé', [
                'member_id' => $member->id,
                'email' => $request->email,
                'ip_address' => $request->ip(),
            ]);

            return back()
                ->withErrors([
                    'email' => '⚠️ Votre compte a été désactivé. Veuillez contacter l\'administrateur.',
                ])
                ->withInput($request->only('email'));
        }

        // Attempt to authenticate
        if (Auth::guard('client')->attempt($credentials, $request->filled('remember'))) {
            // Regenerate session to prevent fixation attacks
            $request->session()->regenerate();

            // Log successful login
            Log::channel('library')->info('Adhérent connecté', [
                'member_id' => Auth::guard('client')->id(),
                'member_email' => Auth::guard('client')->user()->email,
                'member_name' => Auth::guard('client')->user()->firstname . ' ' . Auth::guard('client')->user()->lastname,
                'ip_address' => $request->ip(),
            ]);

            // Redirect to client dashboard
            return redirect()->intended(route('client.dashboard'))
                ->with('success', '👋 Bonjour ' . Auth::guard('client')->user()->firstname . ' ! Content de vous revoir.');
        }

        // Log failed login attempt
        Log::channel('library')->warning('Tentative de connexion échouée (adhérent)', [
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
     * Handle client logout
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $memberEmail = Auth::guard('client')->user()->email ?? 'N/A';
        $memberName = Auth::guard('client')->user()->firstname ?? 'N/A';

        // Log logout
        Log::channel('library')->info('Adhérent déconnecté', [
            'member_id' => Auth::guard('client')->id(),
            'member_email' => $memberEmail,
            'member_name' => $memberName,
            'ip_address' => $request->ip(),
        ]);

        // Logout
        Auth::guard('client')->logout();

        // Invalidate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to login with success message
        return redirect()->route('client.login')
            ->with('success', '👋 Déconnexion réussie ! À bientôt.');
    }
}