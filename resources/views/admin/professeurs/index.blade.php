@extends('layouts.admin')

@section('title', 'Professeurs')
@section('subtitle', 'Gestion des professeurs')

@section('actions')
    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importModal">
        <i class="bi bi-file-earmark-excel me-2"></i> Importer Excel
    </button>
    <a href="{{ route('admin.professeurs.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i> Nouveau professeur
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Liste des professeurs</h5>
        <form method="GET" class="mt-3 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Rechercher par nom, prénom, email, téléphone ou spécialité..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Rechercher
            </button>
            @if(request('search'))
                <a href="{{ route('admin.professeurs.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-x-circle"></i> Effacer
                </a>
            @endif
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Spécialité</th>
                        <th>Heures/mois</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($professeurs as $professeur)
                        <tr>
                            <td>{{ ($professeurs->currentPage() - 1) * $professeurs->perPage() + $loop->iteration }}</td>
                            <td>
                                <strong>{{ $professeur->prenom }} {{ $professeur->nom }}</strong>
                            </td>
                            <td>{{ $professeur->email }}</td>
                            <td>{{ $professeur->telephone ?? '-' }}</td>
                            <td>{{ $professeur->specialite ?? '-' }}</td>
                            <td>
                                @php
                                    $heuresActuelles = $professeur->getHeuresMensuellesActuelles();
                                    $maxHeures = $professeur->max_heures_mensuel;
                                @endphp
                                @if($maxHeures)
                                    <span class="badge {{ $heuresActuelles >= $maxHeures ? 'bg-danger' : ($heuresActuelles >= $maxHeures * 0.7 ? 'bg-warning' : 'bg-info') }}">
                                        {{ \App\Models\EmploiDuTemps::formatHeures($heuresActuelles) }} / {{ \App\Models\EmploiDuTemps::formatHeures($maxHeures) }}
                                    </span>
                                @else
                                    <span class="text-muted">∞</span>
                                @endif
                            </td>
                            <td>
                                @if($professeur->actif)
                                    <span class="badge bg-success">Actif</span>
                                @else
                                    <span class="badge bg-danger">Inactif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.professeurs.show', $professeur) }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.professeurs.edit', $professeur) }}" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.professeurs.destroy', $professeur) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle me-2"></i>Aucun professeur trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    @if($professeurs->hasPages())
        <div class="card-footer px-4 py-3">
            {{ $professeurs->links() }}
        </div>
    @endif
</div>
@endsection

{{-- Import Modal --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.professeurs.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i class="bi bi-file-earmark-excel me-2"></i>Importer des professeurs
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier Excel (.xlsx, .xls) ou CSV</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                        <div class="form-text mt-2 text-info">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            Un compte utilisateur sera automatiquement créé pour chaque professeur.
                        </div>
                    </div>
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Colonnes attendues :</strong>
                        <ul class="mb-0 mt-2">
                            <li><strong>Mle / Matricule</strong> (Requis)</li>
                            <li>(Supporte <em>Mle Affecté Présentiel/Syn Actif</em>)</li>
                            <li><strong>Nom</strong> & <strong>Prénom</strong> (ou <em>Formateur</em>)</li>
                            <li>(Supporte <em>Formateur Affecté Présentiel/Syn Actif</em>)</li>
                            <li><strong>Groupe</strong> & <strong>Module</strong> (Optionnel - Affectation)</li>
                            <li>Email (Auto-généré si vide)</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload me-2"></i>Importer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


