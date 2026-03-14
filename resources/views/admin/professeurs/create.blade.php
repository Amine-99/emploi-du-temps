?@extends('layouts.admin')

@section('title', 'Nouveau Professeur')
@section('subtitle', 'Ajouter un nouveau professeur')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Informations du professeur</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.professeurs.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="matricule" class="form-label">Matricule <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('matricule') is-invalid @enderror"
                                   id="matricule" name="matricule" value="{{ old('matricule') }}" required>
                            @error('matricule')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                   id="nom" name="nom" value="{{ old('nom') }}" required>
                            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('prenom') is-invalid @enderror"
                                   id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                            @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                                   id="telephone" name="telephone" value="{{ old('telephone') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="specialite" class="form-label">Spécialité</label>
                        <input type="text" class="form-control @error('specialite') is-invalid @enderror"
                               id="specialite" name="specialite" value="{{ old('specialite') }}"
                               placeholder="Ex: Développement Web, Réseaux...">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="max_heures_mensuel" class="form-label">
                                <i class="bi bi-clock-history me-1"></i>Max heures / mois
                            </label>
                            <input type="number" class="form-control @error('max_heures_mensuel') is-invalid @enderror"
                                   id="max_heures_mensuel" name="max_heures_mensuel"
                                   value="{{ old('max_heures_mensuel') }}"
                                   min="1" max="200"
                                   placeholder="Ex: 40 (vide = pas de limite)">
                            @error('max_heures_mensuel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="modules" class="form-label">Modules assignés</label>
                            <select name="modules[]" id="modules" class="form-select" multiple size="5">
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}" {{ collect(old('modules'))->contains($module->id) ? 'selected' : '' }}>
                                        [{{ $module->code }}] {{ $module->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Maintenez Ctrl pour en sélectionner plusieurs</small>
                        </div>
                        <div class="col-md-4">
                            <label for="groupes" class="form-label">Groupes assignés</label>
                            <select name="groupes[]" id="groupes" class="form-select" multiple size="5">
                                @foreach($groupes as $groupe)
                                    <option value="{{ $groupe->id }}" {{ collect(old('groupes'))->contains($groupe->id) ? 'selected' : '' }}>
                                        {{ $groupe->nom }} ({{ $groupe->filiere->code ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filieres" class="form-label">Filières assignées</label>
                            <select name="filieres[]" id="filieres" class="form-select" multiple size="5">
                                @foreach($filieres as $filiere)
                                    <option value="{{ $filiere->id }}" {{ collect(old('filieres'))->contains($filiere->id) ? 'selected' : '' }}>
                                        {{ $filiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="actif" name="actif" value="1"
                                       {{ old('actif', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="actif">Professeur actif</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="creer_compte" name="creer_compte" value="1">
                                <label class="form-check-label" for="creer_compte">
                                    Créer un compte utilisateur <small class="text-muted">(mot de passe: password123)</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.professeurs.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i> Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


