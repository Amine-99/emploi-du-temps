?@extends('layouts.admin')

@section('title', 'Modifier Filière')
@section('subtitle', $filiere->nom)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Modifier la filière</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.filieres.update', $filiere) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                   id="code" name="code" value="{{ old('code', $filiere->code) }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                   id="nom" name="nom" value="{{ old('nom', $filiere->nom) }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3">{{ old('description', $filiere->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="niveau" class="form-label">Niveau <span class="text-danger">*</span></label>
                            <select class="form-select @error('niveau') is-invalid @enderror"
                                    id="niveau" name="niveau" required>
                                @foreach($niveaux as $niveau)
                                    <option value="{{ $niveau }}" {{ old('niveau', $filiere->niveau) == $niveau ? 'selected' : '' }}>
                                        {{ $niveau }}
                                    </option>
                                @endforeach
                            </select>
                            @error('niveau')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="duree_formation" class="form-label">Durée de formation <span class="text-danger">*</span></label>
                            <select class="form-select @error('duree_formation') is-invalid @enderror"
                                    id="duree_formation" name="duree_formation" required>
                                <option value="1" {{ old('duree_formation', $filiere->duree_formation) == 1 ? 'selected' : '' }}>1 an</option>
                                <option value="2" {{ old('duree_formation', $filiere->duree_formation) == 2 ? 'selected' : '' }}>2 ans</option>
                                <option value="3" {{ old('duree_formation', $filiere->duree_formation) == 3 ? 'selected' : '' }}>3 ans</option>
                            </select>
                            @error('duree_formation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="active" name="active" value="1"
                                {{ old('active', $filiere->active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">
                                Filière active
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.filieres.index') }}" class="btn btn-secondary">
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


