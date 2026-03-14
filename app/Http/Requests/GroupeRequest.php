<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:50',
            'filiere_id' => 'required|exists:filieres,id,active,1',
            'annee' => 'required|integer|min:1|max:2',
            'effectif' => 'nullable|integer|min:0',
            'annee_scolaire' => 'required|string|max:20',
            'actif' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom du groupe est obligatoire',
            'filiere_id.required' => 'La filière est obligatoire',
            'filiere_id.exists' => 'La filière sélectionnée n\'existe pas',
            'annee.required' => 'L\'année est obligatoire',
            'annee_scolaire.required' => 'L\'année scolaire est obligatoire',
        ];
    }
}
