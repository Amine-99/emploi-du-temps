@extends('layouts.admin')

@section('title', $groupe->nom)
@section('subtitle', 'Détails du groupe')

@section('actions')
    <a href__="{{ route('admin.emplois.grille', ['groupe_id' => $groupe->id]) }}" class="btn btn-info me-2">
        <i class="bi bi-calendar3 me-2"></i> Voir EDT
    </a>
    <a href="{{ route('admin.groupes.edit', $groupe) }}" class="btn btn-warning">
        <i class="bi bi-pencil me-2"></i> Modifier
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations</h5></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th>Filière:</th><td>{{ $groupe->filiere->nom }}</td></tr>
                    <tr><th>Année:</th><td>{{ $groupe->annee }}ère année</td></tr>
                    <tr><th>Effectif:</th><td>{{ $groupe->effectif }} stagiaires</td></tr>
                    <tr><th>Année scolaire:</th><td>{{ $groupe->annee_scolaire }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-mortarboard me-2"></i>Stagiaires ({{ $groupe->etudiants->count() }})</h5>
                <a href="{{ route('admin.etudiants.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> Ajouter
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr><th>CEF</th><th>Nom</th><th>Prénom</th><th>Email</th></tr>
                        </thead>
                        <tbody>
                            @forelse($groupe->etudiants as $etudiant)
                                <tr>
                                    <td>{{ $etudiant->cef }}</td>
                                    <td>{{ $etudiant->nom }}</td>
                                    <td>{{ $etudiant->prenom }}</td>
                                    <td>{{ $etudiant->email ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-3">Aucun stagiaire</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="{{ route('admin.groupes.index') }}" class="btn btn-secondary">
    <i class="bi bi-arrow-left me-2"></i> Retour
</a>
@endsection
