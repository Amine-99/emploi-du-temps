@extends('layouts.admin')

@section('title', 'Nouvelle Annonce')
@section('subtitle', 'Créer une annonce pour les stagiaires')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-megaphone me-2"></i>Rédiger l'annonce</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.annonces.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required placeholder="Ex: Changement d'horaires, Jour férié...">
                        @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label for="contenu" class="form-label">Contenu <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('contenu') is-invalid @enderror" id="contenu" name="contenu" rows="6" required placeholder="Écrivez le contenu de l'annonce...">{{ old('contenu') }}</textarea>
                        @error('contenu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.annonces.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Annuler</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i> Publier l'annonce</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
