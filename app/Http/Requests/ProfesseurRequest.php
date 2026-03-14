<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfesseurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'actif' => $this->has('actif'),
        ]);
    }

    public function rules(): array
    {
        $professeurId = $this->route('professeur')?->id;

        return [
            'matricule' => [
                'required',
                'string',
                'max:50',
                Rule::unique('professeurs', 'matricule')->ignore($professeurId)
            ],
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('professeurs', 'email')->ignore($professeurId)
            ],
            'telephone' => 'nullable|string|max:20',
            'specialite' => 'nullable|string|max:255',
            'actif' => 'boolean',
            'max_heures_mensuel' => 'nullable|integer|min:1|max:200',
            'taux_horaire' => 'nullable|numeric|min:0',
            'modules' => 'nullable|array',
            'modules.*' => 'exists:modules,id',
            'groupes' => 'nullable|array',
            'groupes.*' => 'exists:groupes,id',
            'filieres' => 'nullable|array',
            'filieres.*' => 'exists:filieres,id',
        ];
    }

    public function messages(): array
    {
        return [
            'matricule.required' => 'Le matricule est obligatoire',
            'matricule.unique' => 'Ce matricule existe déjà',
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'email.required' => 'L\'email est obligatoire',
            'email.unique' => 'Cet email existe déjà',
            'max_heures_mensuel.integer' => 'Le max d\'heures doit être un nombre entier',
            'max_heures_mensuel.min' => 'Le max d\'heures doit être au moins 1',
            'max_heures_mensuel.max' => 'Le max d\'heures ne peut pas dépasser 200',
        ];
    }
}
