?@extends('layouts.admin')

@section('title', 'Modifier Groupe')
@section('subtitle', $groupe->nom)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Modifier le groupe</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.groupes.update', $groupe) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom du groupe <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                   id="nom" name="nom" value="{{ old('nom', $groupe->nom) }}" required>
                            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="filiere_id" class="form-label">Filière <span class="text-danger">*</span></label>
                            <select class="form-select @error('filiere_id') is-invalid @enderror" id="filiere_id" name="filiere_id" required>
                                @foreach($filieres as $filiere)
                                    <option value="{{ $filiere->id }}" {{ old('filiere_id', $groupe->filiere_id) == $filiere->id ? 'selected' : '' }}>
                                        {{ $filiere->code }} - {{ $filiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('filiere_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="annee" class="form-label">Année <span class="text-danger">*</span></label>
                            <select class="form-select" id="annee" name="annee" required>
                                <option value="1" {{ old('annee', $groupe->annee) == 1 ? 'selected' : '' }}>1ère année</option>
                                <option value="2" {{ old('annee', $groupe->annee) == 2 ? 'selected' : '' }}>2ème année</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="effectif" class="form-label">Effectif</label>
                            <input type="number" class="form-control" id="effectif" name="effectif"
                                   value="{{ old('effectif', $groupe->effectif) }}" min="0">
                        </div>
                        <div class="col-md-4">
                            <label for="annee_scolaire" class="form-label">Année scolaire <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="annee_scolaire" name="annee_scolaire"
                                   value="{{ old('annee_scolaire', $groupe->annee_scolaire) }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="hidden" name="actif" value="0">
                                <input class="form-check-input" type="checkbox" role="switch" id="actif" name="actif" value="1" {{ old('actif', $groupe->actif) ? 'checked' : '' }}>
                                <label class="form-check-label" for="actif">Groupe Actif (affiché dans les listes)</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.groupes.index') }}" class="btn btn-secondary">
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


