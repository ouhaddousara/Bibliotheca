<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $member = Auth::guard('client')->user();
        return view('client.profile-edit', compact('member'));
    }

    /**
     * Update the profile information.
     */
    public function update(Request $request)
    {
        $member = Auth::guard('client')->user();

        // Validation des données
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|string|min:8|confirmed',
        ], [
            'lastname.required' => 'Le nom est obligatoire',
            'firstname.required' => 'Le prénom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.unique' => 'Cet email est déjà utilisé',
            'new_password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'new_password.confirmed' => 'Les mots de passe ne correspondent pas',
            'current_password.required_with' => 'Le mot de passe actuel est requis pour modifier le mot de passe',
        ]);

        // Vérifier le mot de passe actuel si modification demandée
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $member->password)) {
                return back()
                    ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect'])
                    ->withInput();
            }

            // Mettre à jour le mot de passe
            $member->password = Hash::make($validated['new_password']);
        }

        // Mettre à jour les autres informations
        $member->update([
            'lastname' => $validated['lastname'],
            'firstname' => $validated['firstname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $member->phone,
            'address' => $validated['address'] ?? $member->address,
        ]);

        // Log de l'activité
        Log::channel('library')->info('Adhérent a mis à jour son profil', [
            'member_id' => $member->id,
            'member_email' => $member->email,
            'password_changed' => $request->filled('new_password'),
        ]);

        return redirect()->route('client.profile')
            ->with('success', '✅ Votre profil a été mis à jour avec succès !');
    }
}