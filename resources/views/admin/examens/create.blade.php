?@extends('layouts.admin')

@section('title', 'Nouvel Examen')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.examens.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Module</label>
                            <select name="module_id" class="form-select @error('module_id') is-invalid @enderror" required>
                                <option value="">-- Choisir un module --</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}">{{ $module->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Groupe</label>
                            <select name="groupe_id" class="form-select @error('groupe_id') is-invalid @enderror" required>
                                <option value="">-- Choisir un groupe --</option>
                                @foreach($groupes as $groupe)
                                    <option value="{{ $groupe->id }}">{{ $groupe->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Type d'examen</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">-- Choisir le type --</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Coefficient</label>
                            <input type="number" step="0.5" name="coefficient" value="1" class="form-control @error('coefficient') is-invalid @enderror" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Heure Début</label>
                            <input type="time" name="heure_debut" class="form-control @error('heure_debut') is-invalid @enderror" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Heure Fin</label>
                            <input type="time" name="heure_fin" class="form-control @error('heure_fin') is-invalid @enderror" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Salle (Optionnel)</label>
                        <select name="salle_id" class="form-select">
                            <option value="">-- Choisir une salle --</option>
                            @foreach($salles as $salle)
                                <option value="{{ $salle->id }}">{{ $salle->nom }} ({{ $salle->type }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-end">
                        <a href="{{ route('admin.examens.index') }}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


