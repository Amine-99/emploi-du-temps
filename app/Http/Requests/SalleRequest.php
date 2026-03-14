<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $salleId = $this->route('salle')?->id;

        return [
            'numero' => [
                'required',
                'string',
                'max:20',
                Rule::unique('salles', 'numero')->ignore($salleId)
            ],
            'nom' => 'required|string|max:100',
            'type' => 'required|in:Cours,TP,Atelier,Amphithéâtre',
            'capacite' => 'required|integer|min:1',
            'equipements' => 'nullable|string',
            'batiment' => 'nullable|string|max:100',
            'disponible' => 'boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'numero.required' => 'Le numéro est obligatoire',
            'numero.unique' => 'Ce numéro existe déjà',
            'nom.required' => 'Le nom est obligatoire',
            'type.required' => 'Le type est obligatoire',
            'capacite.required' => 'La capacité est obligatoire',
        ];
    }
}
