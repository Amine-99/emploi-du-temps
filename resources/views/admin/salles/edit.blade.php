@extends('layouts.admin')

@section('title', 'Modifier Salle')
@section('subtitle', $salle->nom)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Modifier la salle</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.salles.update', $salle) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="numero" class="form-label">Numéro <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('numero') is-invalid @enderror"
                                   id="numero" name="numero" value="{{ old('numero', $salle->numero) }}" required>
                            @error('numero')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8">
                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $salle->nom) }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ old('type', $salle->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="capacite" class="form-label">Capacité <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="capacite" name="capacite"
                                   value="{{ old('capacite', $salle->capacite) }}" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label for="batiment" class="form-label">Bâtiment</label>
                            <input type="text" class="form-control" id="batiment" name="batiment" value="{{ old('batiment', $salle->batiment) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="equipements" class="form-label">Équipements</label>
                        <textarea class="form-control" id="equipements" name="equipements" rows="2">{{ old('equipements', $salle->equipements) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="disponible" name="disponible" value="1"
                                   {{ old('disponible', $salle->disponible) ? 'checked' : '' }}>
                            <label class="form-check-label" for="disponible">Salle disponible</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.salles.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Annuler</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i> Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


