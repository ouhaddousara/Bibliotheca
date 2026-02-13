<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // ← AJOUTÉ
use Illuminate\Support\Facades\Log;  // ← AJOUTÉ
use App\Models\Member;                // ← AJOUTÉ

class ClientLoginController extends Controller
{
    /**
     * Show the client login form.
     */
    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    /**
     * Show the client registration form.
     */
    public function showRegisterForm()
    {
        return view('client.auth.register');
    }

    /**
     * Handle client login attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('client')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('client.dashboard'))
                ->with('success', '👋 Bonjour ' . Auth::guard('client')->user()->firstname . ' !');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect'])->onlyInput('email');
    }

    /**
     * Handle client registration.
     */
    public function register(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ], [
            'lastname.required' => 'Le nom est obligatoire',
            'firstname.required' => 'Le prénom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.unique' => 'Cet email est déjà utilisé',
            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
        ]);

        // Création du compte adhérent
        $member = Member::create([
            'lastname' => $validated['lastname'],
            'firstname' => $validated['firstname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        // Journalisation
        Log::channel('library')->info('Nouvel adhérent inscrit', [
            'member_id' => $member->id,
            'member_email' => $member->email,
            'ip_address' => $request->ip(),
        ]);

        // Connexion automatique après inscription
        Auth::guard('client')->login($member);

        return redirect()->route('client.dashboard')
            ->with('success', '🎉 Félicitations ' . $member->firstname . ' ! Votre compte a été créé avec succès. Bienvenue dans notre bibliothèque !');
    }

    /**
     * Handle client logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('client.login')->with('success', 'Déconnexion réussie');
    }
}