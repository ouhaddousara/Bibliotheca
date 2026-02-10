<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    public function index(Request $request)
{
    $query = Member::query();

    // Filtre par statut
    if ($request->status === 'active') {
        $query->where('is_active', true);
    } elseif ($request->status === 'inactive') {
        $query->where('is_active', false);
    }

    // Filtre par date
    if ($request->date === 'week') {
        $query->where('created_at', '>=', now()->subWeek());
    } elseif ($request->date === 'month') {
        $query->where('created_at', '>=', now()->subMonth());
    } elseif ($request->date === 'year') {
        $query->where('created_at', '>=', now()->subYear());
    }

    // Recherche
    if ($request->search) {
        $query->where(function($q) use ($request) {
            $q->where('firstname', 'like', "%{$request->search}%")
              ->orWhere('lastname', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
        });
    }

    $members = $query->withCount(['loans as active_loans' => function ($q) {
        $q->whereNull('returned_at');
    }])
    ->latest()
    ->paginate(15);

    return view('admin.members.index', compact('members'));
}

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        try {
            $member = Member::create([
                'lastname' => $validated['lastname'],
                'firstname' => $validated['firstname'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'password' => Hash::make($validated['password']),
                'is_active' => $validated['is_active'] ?? true,
            ]);

            Log::channel('library')->info('Adhérent créé', [
                'member_id' => $member->id,
                'name' => $member->firstname . ' ' . $member->lastname,
                'admin_id' => auth('admin')->id(),
            ]);

            return redirect()->route('admin.members.index')
                ->with('success', 'Adhérent ajouté avec succès ! 👥');

        } catch (\Exception $e) {
            Log::channel('library')->error('Erreur création adhérent', [
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création.');
        }
    }

    public function show(Member $member)
    {
        $member->load(['loans' => function ($query) {
            $query->with('copy.book')
                ->latest();
        }]);

        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        try {
            $updateData = [
                'lastname' => $validated['lastname'],
                'firstname' => $validated['firstname'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? $member->phone,
                'address' => $validated['address'] ?? $member->address,
                'is_active' => $validated['is_active'] ?? $member->is_active,
            ];

            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            $member->update($updateData);

            Log::channel('library')->info('Adhérent mis à jour', [
                'member_id' => $member->id,
                'admin_id' => auth('admin')->id(),
            ]);

            return redirect()->route('admin.members.index')
                ->with('success', 'Adhérent mis à jour avec succès ! ✏️');

        } catch (\Exception $e) {
            Log::channel('library')->error('Erreur mise à jour adhérent', [
                'member_id' => $member->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la mise à jour.');
        }
    }

    public function destroy(Member $member)
    {
        try {
            $activeLoans = $member->loans()->whereNull('returned_at')->count();
            
            if ($activeLoans > 0) {
                return back()
                    ->with('error', 'Impossible de supprimer cet adhérent : il a ' . $activeLoans . ' emprunt(s) en cours.');
            }

            $member->delete();

            Log::channel('library')->info('Adhérent supprimé', [
                'member_id' => $member->id,
                'admin_id' => auth('admin')->id(),
            ]);

            return redirect()->route('admin.members.index')
                ->with('success', 'Adhérent supprimé avec succès ! 🗑️');

        } catch (\Exception $e) {
            Log::channel('library')->error('Erreur suppression adhérent', [
                'member_id' => $member->id,
                'error' => $e->getMessage(),
            ]);

            return back()
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }
}
