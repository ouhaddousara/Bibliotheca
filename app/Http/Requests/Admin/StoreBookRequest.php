<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
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
            'isbn' => [
                'required',
                'string',
                'max:13',
                Rule::unique('books')->ignore($this->route('book')),
                'regex:/^\d{10}(\d{3})?$/',
            ],
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'author' => [
                'required',
                'string',
                'max:255',
            ],
            'publisher' => [
                'nullable',
                'string',
                'max:255',
            ],
            'year' => [
                'nullable',
                'integer',
                'min:1800',
                'max:' . date('Y'),
            ],
            'category' => [
                'required',
                'string',
                Rule::in(array_keys(config('library.categories', []))),
            ],
            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'cover' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // 2MB max
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'isbn.required' => '⚠️ Le ISBN est obligatoire',
            'isbn.unique' => '⚠️ Ce ISBN existe déjà dans la bibliothèque',
            'isbn.regex' => '⚠️ Format ISBN invalide (10 ou 13 chiffres)',
            'isbn.max' => '⚠️ Le ISBN ne doit pas dépasser 13 caractères',
            'title.required' => '⚠️ Le titre est obligatoire',
            'title.max' => '⚠️ Le titre ne doit pas dépasser 255 caractères',
            'author.required' => '⚠️ L\'auteur est obligatoire',
            'author.max' => '⚠️ Le nom de l\'auteur ne doit pas dépasser 255 caractères',
            'year.min' => '⚠️ L\'année doit être supérieure à 1800',
            'year.max' => '⚠️ L\'année ne peut pas être dans le futur',
            'category.required' => '⚠️ La catégorie est obligatoire',
            'category.in' => '⚠️ Catégorie invalide',
            'description.max' => '⚠️ La description ne doit pas dépasser 2000 caractères',
            'cover.image' => '⚠️ Le fichier doit être une image',
            'cover.mimes' => '⚠️ Format d\'image invalide (jpeg, png, jpg, gif uniquement)',
            'cover.max' => '⚠️ L\'image ne doit pas dépasser 2 Mo',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'isbn' => 'ISBN',
            'title' => 'titre',
            'author' => 'auteur',
            'publisher' => 'éditeur',
            'year' => 'année',
            'category' => 'catégorie',
            'description' => 'description',
            'cover' => 'couverture',
        ];
    }
}