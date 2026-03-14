@extends('layouts.admin')

@section('title', 'Rapports Professeurs')
@section('subtitle', 'Suivi des validations, annulations et absences')

@section('content')
<div class="row mb-4">
    <!-- Demandes d'annulation -->
    <div class="col-md-12 mb-4">
        <div class="card shadow-sm border-warning">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Demandes d'Annulation en Attente</h5>
                <span class="badge bg-dark">{{ $demandesAnnulation->count() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date Exécution</th>
                                <th>Professeur</th>
                                <th>Module & Groupe</th>
                                <th>Motif</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($demandesAnnulation as $demande)
                                <tr>
                                    <td>{{ $demande->jour }} Ã  {{ substr($demande->heure_debut, 0, 5) }}</td>
                                    <td>{{ $demande->professeur->nom_complet }}</td>
                                    <td>
                                        <strong>{{ $demande->module->nom }}</strong><br>
                                        <small class="text-muted">{{ $demande->groupe->nom }}</small>
                                    </td>
                                    <td><span class="text-danger">{{ $demande->motif_annulation }}</span></td>
                                    <td class="text-end">
                                        <form action="{{ route('admin.emplois.approve', $demande) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Approuver">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.emplois.reject', $demande) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="Refuser">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-3">Aucune demande en attente.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières Validations -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-check-circle me-2"></i>Dernières Séances Validées</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Professeur</th>
                                <th>Module</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentValidations as $validation)
                                @if($validation->emploiDuTemps)
                                <tr>
                                    <td>{{ $validation->date->format('d/m/Y') }}</td>
                                    <td>{{ $validation->emploiDuTemps->professeur->nom_complet }}</td>
                                    <td>{{ $validation->emploiDuTemps->module->nom }}</td>
                                </tr>
                                @endif
                            @empty
                                <tr><td colspan="3" class="text-center text-muted py-3">Aucune validation récente.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières Absences -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-person-x me-2"></i>Dernières Absences Stagiaires</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Stagiaire</th>
                                <th>Module</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAbsences as $absence)
                                @if($absence->seanceRealisation && $absence->seanceRealisation->emploiDuTemps)
                                <tr>
                                    <td>{{ $absence->seanceRealisation->date->format('d/m/Y') }}</td>
                                    <td>{{ $absence->etudiant->nom_complet }}</td>
                                    <td><small>{{ $absence->seanceRealisation->emploiDuTemps->module->nom }}</small></td>
                                    <td>
                                        <span class="badge {{ $absence->status == 'Justifié' ? 'bg-warning text-dark' : 'bg-danger' }}">
                                            {{ $absence->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endif
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Aucune absence récente répertoriée.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


