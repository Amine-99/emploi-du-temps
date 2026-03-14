<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FiliereRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'active' => $this->has('active'),
        ]);
    }

    public function rules(): array
    {
        $filiereId = $this->route('filiere')?->id;

        return [
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('filieres', 'code')->ignore($filiereId)
            ],
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duree_formation' => 'required|integer|min:1|max:3',
            'niveau' => 'required|in:Technicien,Technicien Spécialisé,Qualification',
            'active' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Le code est obligatoire',
            'code.unique' => 'Ce code existe déjà',
            'nom.required' => 'Le nom est obligatoire',
            'niveau.required' => 'Le niveau est obligatoire',
        ];
    }
}
