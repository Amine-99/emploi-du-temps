@extends('layouts.admin')

@section('title', 'Modifier Stagiaire')
@section('subtitle', $etudiant->nom_complet)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Modifier le stagiaire</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.etudiants.update', $etudiant) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="cef" class="form-label">CEF <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('cef') is-invalid @enderror"
                                   id="cef" name="cef" value="{{ old('cef', $etudiant->cef) }}" required>
                            @error('cef')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $etudiant->nom) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom', $etudiant->prenom) }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $etudiant->email) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone', $etudiant->telephone) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date_naissance" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="date_naissance" name="date_naissance"
                                   value="{{ old('date_naissance', $etudiant->date_naissance?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="groupe_id" class="form-label">Groupe <span class="text-danger">*</span></label>
                            <select class="form-select" id="groupe_id" name="groupe_id" required>
                                @foreach($groupes as $groupe)
                                    <option value="{{ $groupe->id }}" {{ old('groupe_id', $etudiant->groupe_id) == $groupe->id ? 'selected' : '' }}>
                                        {{ $groupe->nom }} - {{ $groupe->filiere->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="actif" name="actif" value="1"
                                   {{ old('actif', $etudiant->actif) ? 'checked' : '' }}>
                            <label class="form-check-label" for="actif">Stagiaire actif</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Annuler</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i> Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
