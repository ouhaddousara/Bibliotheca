<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; // ← Ajout crucial

class Member extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'members';

    protected $fillable = [
        'lastname',
        'firstname',
        'email',
        'phone',
        'address',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the loans for the member.
     */
    public function loans(): HasMany // ← RELATION CRITIQUE AJOUTÉE
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Get active loans (not returned yet).
     */
    public function activeLoans()
    {
        return $this->loans()->whereNull('returned_at');
    }

    /**
     * Get the member's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Get active status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? '✅ Actif' : '⚠️ Inactif';
    }

    /**
     * Scope for active members only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}