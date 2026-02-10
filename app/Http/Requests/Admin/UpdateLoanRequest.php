<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLoanRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'return_condition' => [
                'required',
                'in:good,damaged,lost',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'return_condition.required' => '⚠️ Veuillez spécifier l\'état de retour',
            'return_condition.in' => '⚠️ État de retour invalide',
            'notes.max' => '⚠️ Les notes ne doivent pas dépasser 500 caractères',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'return_condition' => 'état de retour',
            'notes' => 'notes',
        ];
    }
}