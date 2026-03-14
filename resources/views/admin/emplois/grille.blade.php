?@extends('layouts.admin')

@section('title', 'Grille Emploi du Temps')
@section('subtitle', $groupe ? $groupe->nom . ' - ' . $groupe->filiere->nom : 'Sélectionnez un groupe')

@section('actions')
    @if(request('view') === 'trashed')
        <a href="{{ route('admin.emplois.grille', ['groupe_id' => request('groupe_id')]) }}" class="btn btn-secondary me-2">
            <i class="bi bi-arrow-left me-2"></i> Grille Actuelle
        </a>
    @else
        <a href="{{ route('admin.emplois.grille', ['groupe_id' => request('groupe_id'), 'view' => 'trashed']) }}" class="btn btn-warning me-2">
            <i class="bi bi-archive me-2"></i> Grilles Archivées
        </a>
    @endif
    @if($groupe)
        <a href="{{ route('admin.emplois.pdf', ['groupe_id' => $groupe->id, 'view' => request('view')]) }}" class="btn btn-danger me-2">
            <i class="bi bi-file-pdf me-2"></i> Export PDF
        </a>
    @endif
    <a href="{{ route('admin.emplois.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i> Nouvelle séance
    </a>
@endsection

@section('content')
<!-- Sélection du groupe -->
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.emplois.grille') }}" method="GET" class="row g-3 align-items-end">
            @if(request('view') === 'trashed')
                <input type="hidden" name="view" value="trashed">
            @endif
            <div class="col-md-8">
                <label for="groupe_id" class="form-label">Sélectionner un groupe</label>
                <select class="form-select" id="groupe_id" name="groupe_id" onchange="this.form.submit()">
                    <option value="">-- Choisir un groupe --</option>
                    @foreach($groupes as $g)
                        <option value="{{ $g->id }}" {{ $groupeId == $g->id ? 'selected' : '' }}>
                            {{ $g->nom }} - {{ $g->filiere->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-2"></i> Afficher
                </button>
            </div>
        </form>
    </div>
</div>

@if($groupe)
<!-- Grille emploi du temps -->
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead style="background-color: #003366; color: white;">
                    <tr>
                        <th width="100">Horaire</th>
                        @foreach($jours as $jour)
                            <th class="text-center">{{ $jour }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($creneaux as $heureDebut => $heureFin)
                        <tr>
                            <td class="align-middle text-center bg-light">
                                <strong>{{ $heureDebut }}</strong><br><small class="text-muted">{{ $heureFin }}</small>
                            </td>
                            @foreach($jours as $jour)
                                @php
                                    $seance = isset($emplois[$jour])
                                        ? $emplois[$jour]->first(function($s) use ($heureDebut) {
                                            return substr($s->heure_debut, 0, 5) == $heureDebut;
                                        })
                                        : null;
                                @endphp
                                <td class="p-2 {{ $seance ? ($seance->is_examen ? 'bg-danger bg-opacity-10' : 'bg-primary bg-opacity-10') : '' }}">
                                    @if($seance)
                                        <div class="p-2 rounded bg-white shadow-sm border-start border-4 {{ $seance->is_examen ? 'border-danger' : 'border-primary' }}">
                                            @if($seance->is_examen)
                                                <span class="badge bg-danger mb-1">EXAMEN</span>
                                            @endif
                                            <strong class="d-block text-dark">{{ $seance->module->nom }}</strong>
                                            <small class="d-block text-secondary">
                                                <i class="bi bi-person me-1"></i>{{ $seance->professeur->nom_complet }}
                                            </small>
                                            <small class="d-block text-secondary">
                                                @if($seance->type_seance === 'Teams')
                                                    <span class="badge bg-info p-1"><i class="bi bi-laptop me-1"></i>Teams</span>
                                                @else
                                                    <i class="bi bi-building me-1"></i>{{ $seance->salle->nom }}
                                                @endif
                                            </small>
                                            <div class="mt-2 text-center">
                                                @if(request('view') === 'trashed')
                                                    <span class="badge bg-danger">Archivée le {{ $seance->deleted_at->format('d/m/Y') }}</span>
                                                @else
                                                    <a href="{{ route('admin.emplois.edit', $seance) }}" class="btn btn-sm btn-outline-warning py-0 px-2" title="Modifier">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="alert alert-info border-0 shadow-sm">
    <i class="bi bi-info-circle me-2"></i> Veuillez sélectionner un groupe pour afficher son emploi du temps.
</div>
@endif
@endsection


