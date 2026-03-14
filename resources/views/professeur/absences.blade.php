?@extends('layouts.professeur')

@section('title', 'Gestion des Absences')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-person-x me-2"></i>Dernières Absences & Retards</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date & Séance</th>
                        <th>Groupe / Module</th>
                        <th>Stagiaire</th>
                        <th class="text-center">Statut</th>
                        <th>Commentaire</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absences as $absence)
                        <tr>
                            <td>
                                <div>{{ \Carbon\Carbon::parse($absence->seanceRealisation->date)->locale('fr')->isoFormat('DD MMMM YYYY') }}</div>
                                <small class="text-muted">{{ $absence->seanceRealisation->emploiDuTemps->heure_debut }} - {{ $absence->seanceRealisation->emploiDuTemps->heure_fin }}</small>
                            </td>
                            <td>
                                <div>{{ $absence->seanceRealisation->emploiDuTemps->groupe->nom }}</div>
                                <small class="badge bg-light text-dark">{{ $absence->seanceRealisation->emploiDuTemps->module->nom }}</small>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $absence->etudiant->nom_complet }}</div>
                                <small class="text-muted">{{ $absence->etudiant->cef }}</small>
                            </td>
                            <td class="text-center">
                                @if($absence->status == 'Présent')
                                    <span class="badge bg-success">Présent</span>
                                @elseif($absence->status == 'Absent')
                                    <span class="badge bg-danger">Absent</span>
                                @else
                                    <span class="badge bg-warning text-dark">Justifié</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">{{ $absence->commentaire ?: '-' }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Aucune absence enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($absences->hasPages())
        <div class="card-footer bg-white">
            {{ $absences->links() }}
        </div>
    @endif
</div>
@endsection


