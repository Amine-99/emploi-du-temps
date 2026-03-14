<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModuleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $moduleId = $this->route('module')?->id;

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('modules', 'code')->ignore($moduleId)
            ],
            'nom' => 'required|string|max:255',
            'filiere_ids' => 'required|array|min:1',
            'filiere_ids.*' => 'exists:filieres,id,active,1',
            'coefficient' => 'nullable|numeric|min:0|max:10',
            'semestre' => 'required|integer|min:1|max:4',
            'max_heures_mensuel' => 'nullable|integer|min:1|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Le code est obligatoire',
            'code.unique' => 'Ce code existe déjà',
            'nom.required' => 'Le nom est obligatoire',
            'filiere_ids.required' => 'Au moins une filière est obligatoire',
            'semestre.required' => 'Le semestre est obligatoire',
            'max_heures_mensuel.integer' => 'Le nombre d\'heures doit être un nombre entier',
            'max_heures_mensuel.min' => 'Le nombre d\'heures doit être au moins 1',
            'max_heures_mensuel.max' => 'Le nombre d\'heures ne peut pas dépasser 500',
        ];
    }
}
