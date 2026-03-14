?@extends('layouts.professeur')

@section('title', 'Historique des Séances')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4><i class="bi bi-clock-history me-2"></i>Historique des Séances Validées</h4>
    <a href="{{ route('professeur.dashboard') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-house me-1"></i> Dashboard
    </a>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Module</th>
                                <th>Groupe</th>
                                <th>Horaire</th>
                                <th>Durée</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalMinutes = 0;
                            @endphp
                            @forelse($realisations as $realisation)
                                @php
                                    $emploi = $realisation->emploiDuTemps;
                                    $module = $realisation->module ?? $emploi->module;
                                    $debut = \Carbon\Carbon::parse($emploi->heure_debut);
                                    $fin = \Carbon\Carbon::parse($emploi->heure_fin);
                                    $minutes = $debut->diffInMinutes($fin);
                                    $totalMinutes += $minutes;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ \Carbon\Carbon::parse($realisation->date)->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($realisation->date)->locale('fr')->isoFormat('dddd') }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $module->nom }}</div>
                                        <small class="text-muted">{{ $module->code }}</small>
                                    </td>
                                    <td>{{ $emploi->groupe->nom }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $emploi->heure_debut }} - {{ $emploi->heure_fin }}
                                        </span>
                                    </td>
                                    <td>{{ $minutes / 60 }}h</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="bi bi-info-circle display-4 text-muted mb-3 d-block"></i>
                                        <p class="text-muted">Aucune séance validée pour le moment.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($realisations->count() > 0)
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="4" class="text-end text-uppercase small">Total cumulé :</td>
                                <td>{{ $totalMinutes / 60 }}h</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


