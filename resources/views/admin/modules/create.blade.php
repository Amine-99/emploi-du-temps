?@extends('layouts.admin')

@section('title', 'Nouveau Module')
@section('subtitle', 'Ajouter un nouveau module')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Informations du module</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.modules.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                   id="code" name="code" value="{{ old('code') }}" placeholder="Ex: M101" required>
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8">
                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                   id="nom" name="nom" value="{{ old('nom') }}" required>
                            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="filiere_ids" class="form-label">Filières <span class="text-danger">*</span></label>
                            <select class="form-select @error('filiere_ids') is-invalid @enderror" id="filiere_ids" name="filiere_ids[]" multiple required style="height: 120px;">
                                @foreach($filieres as $filiere)
                                    <option value="{{ $filiere->id }}" {{ (is_array(old('filiere_ids')) && in_array($filiere->id, old('filiere_ids'))) ? 'selected' : '' }}>
                                        {{ $filiere->code }} - {{ $filiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Maintenez Ctrl pour sélectionner plusieurs filières</small>
                            @error('filiere_ids')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="semestre" class="form-label">Semestre <span class="text-danger">*</span></label>
                            <select class="form-select @error('semestre') is-invalid @enderror" id="semestre" name="semestre" required>
                                <option value="1" {{ old('semestre') == 1 ? 'selected' : '' }}>Semestre 1</option>
                                <option value="2" {{ old('semestre') == 2 ? 'selected' : '' }}>Semestre 2</option>
                                <option value="3" {{ old('semestre') == 3 ? 'selected' : '' }}>Semestre 3</option>
                                <option value="4" {{ old('semestre') == 4 ? 'selected' : '' }}>Semestre 4</option>
                            </select>
                            @error('semestre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="coefficient" class="form-label">Coefficient</label>
                            <input type="number" class="form-control" id="coefficient" name="coefficient"
                                   value="{{ old('coefficient', 1) }}" min="0" max="10" step="0.5">
                        </div>
                        <div class="col-md-6">
                            <label for="max_heures_mensuel" class="form-label">
                                <i class="bi bi-clock-history me-1"></i>Module heures
                            </label>
                            <input type="number" class="form-control @error('max_heures_mensuel') is-invalid @enderror"
                                   id="max_heures_mensuel" name="max_heures_mensuel"
                                   value="{{ old('max_heures_mensuel') }}"
                                   min="1" max="500"
                                   placeholder="Ex: 20 (heures total par mois)">
                            @error('max_heures_mensuel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Nombre maximum d'heures autorisées par mois</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.modules.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Annuler</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


