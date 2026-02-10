<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLoanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'member_id' => [
                'required',
                'exists:members,id',
                Rule::exists('members')->where(function ($query) {
                    return $query->where('is_active', true);
                }),
            ],
            'copy_id' => [
                'required',
                'exists:copies,id',
                Rule::exists('copies')->where(function ($query) {
                    return $query->where('status', 'available');
                }),
            ],
            'borrowed_at' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'due_date' => [
                'nullable',
                'date',
                'after:borrowed_at',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'member_id.required' => '⚠️ Veuillez sélectionner un adhérent',
            'member_id.exists' => '⚠️ Adhérent introuvable ou compte désactivé',
            'copy_id.required' => '⚠️ Veuillez sélectionner un exemplaire',
            'copy_id.exists' => '⚠️ Cet exemplaire n\'est pas disponible ou inexistant',
            'borrowed_at.required' => '⚠️ Veuillez spécifier la date d\'emprunt',
            'borrowed_at.date' => '⚠️ Format de date invalide',
            'borrowed_at.before_or_equal' => '⚠️ La date d\'emprunt ne peut pas être dans le futur',
            'due_date.after' => '⚠️ La date de retour doit être après la date d\'emprunt',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'member_id' => 'adhérent',
            'copy_id' => 'exemplaire',
            'borrowed_at' => 'date d\'emprunt',
            'due_date' => 'date de retour',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Nettoyer les inputs
        $this->merge([
            'member_id' => filter_var($this->member_id, FILTER_SANITIZE_NUMBER_INT),
            'copy_id' => filter_var($this->copy_id, FILTER_SANITIZE_NUMBER_INT),
        ]);
    }
}