?@extends('layouts.admin')

@section('title', 'Modifier Professeur')
@section('subtitle', $professeur->nom_complet)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Modifier le professeur</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.professeurs.update', $professeur) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="matricule" class="form-label">Matricule <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('matricule') is-invalid @enderror"
                                   id="matricule" name="matricule" value="{{ old('matricule', $professeur->matricule) }}" required>
                            @error('matricule')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom" name="nom"
                                   value="{{ old('nom', $professeur->nom) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenom" name="prenom"
                                   value="{{ old('prenom', $professeur->prenom) }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ old('email', $professeur->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone"
                                   value="{{ old('telephone', $professeur->telephone) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="specialite" class="form-label">Spécialité</label>
                        <input type="text" class="form-control" id="specialite" name="specialite"
                               value="{{ old('specialite', $professeur->specialite) }}">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="max_heures_mensuel" class="form-label">
                                <i class="bi bi-clock-history me-1"></i>Max heures / mois
                            </label>
                            <input type="number" class="form-control @error('max_heures_mensuel') is-invalid @enderror"
                                   id="max_heures_mensuel" name="max_heures_mensuel"
                                   value="{{ old('max_heures_mensuel', $professeur->max_heures_mensuel) }}"
                                   min="1" max="200"
                                   placeholder="Ex: 40 (vide = pas de limite)">
                            @error('max_heures_mensuel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Laisser vide pour aucune limite d'heures</small>
                        </div>
                    </div>

                    @php
                        $heuresActuelles = $professeur->getHeuresMensuellesActuelles();
                        $maxHeures = $professeur->max_heures_mensuel;
                        $pourcentage = $maxHeures ? round(($heuresActuelles / $maxHeures) * 100) : 0;
                    @endphp

                    @if($maxHeures)
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Heures utilisées ce mois ({{ \App\Models\EmploiDuTemps::formatHeures($heuresActuelles) }} / {{ \App\Models\EmploiDuTemps::formatHeures($maxHeures) }})</label>
                            <div class="progress" style="height: 15px;">
                                <div class="progress-bar {{ $pourcentage >= 90 ? 'bg-danger' : ($pourcentage >= 70 ? 'bg-warning' : 'bg-success') }}"
                                     role="progressbar" style="width: {{ min($pourcentage, 100) }}%">
                                    {{ $pourcentage }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <hr class="my-4">
                    <h6 class="mb-3 text-primary"><i class="bi bi-link-45deg me-2"></i>Assignations administratives</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="modules" class="form-label">Modules enseignés</label>
                            <select name="modules[]" id="modules" class="form-select @error('modules') is-invalid @enderror" multiple size="6">
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}" 
                                        {{ (collect(old('modules', $professeur->modules->pluck('id')))->contains($module->id)) ? 'selected' : '' }}>
                                        [{{ $module->code }}] {{ $module->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Utilisez Ctrl+Clic pour sélection multiple</small>
                            @error('modules')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="groupes" class="form-label">Groupes assignés</label>
                            <select name="groupes[]" id="groupes" class="form-select @error('groupes') is-invalid @enderror" multiple size="6">
                                @foreach($groupes as $groupe)
                                    <option value="{{ $groupe->id }}" 
                                        {{ (collect(old('groupes', $professeur->groupes->pluck('id')))->contains($groupe->id)) ? 'selected' : '' }}>
                                        {{ $groupe->nom }} ({{ $groupe->filiere->code ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('groupes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label for="filieres" class="form-label">Filières assignées</label>
                            <select name="filieres[]" id="filieres" class="form-select @error('filieres') is-invalid @enderror" multiple size="6">
                                @foreach($filieres as $filiere)
                                    <option value="{{ $filiere->id }}" 
                                        {{ (collect(old('filieres', $professeur->filieres->pluck('id')))->contains($filiere->id)) ? 'selected' : '' }}>
                                        {{ $filiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('filieres')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="actif" name="actif" value="1"
                                   {{ old('actif', $professeur->actif) ? 'checked' : '' }}>
                            <label class="form-check-label" for="actif">Professeur actif</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.professeurs.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


