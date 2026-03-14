@extends('layouts.admin')

@section('title', 'Gestion des Stagiaires')
@section('subtitle', 'Liste de tous les stagiaires')

@section('actions')
    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importModal">
        <i class="bi bi-file-earmark-excel me-2"></i> Importer
    </button>
    <a href="{{ route('admin.etudiants.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i> Nouveau stagiaire
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Rechercher par CEF, nom, prénom, email ou groupe..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Rechercher
            </button>
            @if(request('search'))
                <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-x-circle"></i> Effacer
                </a>
            @endif
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>CEF</th>
                        <th>Nom complet</th>
                        <th>Groupe</th>
                        <th>Filière</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($etudiants as $etudiant)
                        <tr>
                            <td><strong>{{ $etudiant->cef }}</strong></td>
                            <td>{{ $etudiant->prenom }} {{ $etudiant->nom }}</td>
                            <td><span class="badge bg-info">{{ $etudiant->groupe->nom }}</span></td>
                            <td>{{ $etudiant->groupe->filiere->nom }}</td>
                            <td>{{ $etudiant->email ?? '-' }}</td>
                            <td>
                                @if($etudiant->actif)<span class="badge bg-success">Actif</span>
                                @else<span class="badge bg-danger">Inactif</span>@endif
                            </td>
                            <td>
                                <a href="{{ route('admin.etudiants.show', $etudiant) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.etudiants.edit', $etudiant) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.etudiants.destroy', $etudiant) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce stagiaire ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Aucun stagiaire trouvé</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($etudiants->hasPages())
        <div class="card-footer px-4 py-3">
            {{ $etudiants->links() }}
        </div>
    @endif
</div>

{{-- Import Modal --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.etudiants.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i class="bi bi-file-earmark-excel me-2"></i>Importer des stagiaires
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier Excel (.xlsx, .xls)</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls" required>
                        <div class="form-text mt-2 text-info">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            Un compte utilisateur sera automatiquement créé pour chaque stagiaire avec l'email <strong>CEF@ofppt-emploi.ma</strong>.
                        </div>
                    </div>
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Colonnes attendues (Première ligne) :</strong>
                        <ul class="mb-0 mt-2">
                            <li><strong>CEF</strong> (Requis)</li>
                            <li><strong>Nom</strong> (Requis)</li>
                            <li><strong>Prenom</strong> (Requis)</li>
                            <li><strong>Groupe</strong> (Requis - Nom du groupe)</li>
                            <li>DateNaissance (Optionnel)</li>
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
@endsection
