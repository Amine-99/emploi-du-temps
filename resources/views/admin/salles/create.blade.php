@extends('layouts.admin')

@section('title', 'Nouvelle Salle')
@section('subtitle', 'Ajouter une nouvelle salle')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Informations de la salle</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.salles.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="numero" class="form-label">Numéro <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('numero') is-invalid @enderror"
                                   id="numero" name="numero" value="{{ old('numero') }}" placeholder="Ex: A101" required>
                            @error('numero')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8">
                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                   id="nom" name="nom" value="{{ old('nom') }}" required>
                            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Sélectionner</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="capacite" class="form-label">Capacité <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('capacite') is-invalid @enderror"
                                   id="capacite" name="capacite" value="{{ old('capacite') }}" min="1" required>
                            @error('capacite')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="batiment" class="form-label">Bâtiment</label>
                            <input type="text" class="form-control" id="batiment" name="batiment" value="{{ old('batiment') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="equipements" class="form-label">Équipements</label>
                        <textarea class="form-control" id="equipements" name="equipements" rows="2"
                                  placeholder="Ex: Projecteur, Tableau blanc, 20 PC...">{{ old('equipements') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="disponible" name="disponible" value="1"
                                   {{ old('disponible', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="disponible">Salle disponible</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.salles.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Annuler</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


