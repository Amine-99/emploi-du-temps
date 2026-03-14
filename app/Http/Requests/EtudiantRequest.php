<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EtudiantRequest extends FormRequest
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
        $etudiantId = $this->route('etudiant')?->id;

        return [
            'cef' => [
                'required',
                'string',
                'max:50',
                Rule::unique('etudiants', 'cef')->ignore($etudiantId)
            ],
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'nullable|email',
            'telephone' => 'nullable|string|max:20',
            'date_naissance' => 'nullable|date',
            'groupe_id' => 'required|exists:groupes,id',
            'actif' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'cef.required' => 'Le CEF est obligatoire',
            'cef.unique' => 'Ce CEF existe déjà',
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'groupe_id.required' => 'Le groupe est obligatoire',
        ];
    }
}
