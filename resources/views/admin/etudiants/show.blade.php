@extends('layouts.admin')

@section('title', $etudiant->nom_complet)
@section('subtitle', 'Détails du stagiaire')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-person me-2"></i>Informations</h5></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th width="150">CEF:</th><td>{{ $etudiant->cef }}</td></tr>
                    <tr><th>Groupe:</th><td><span class="badge bg-info">{{ $etudiant->groupe->nom }}</span></td></tr>
                    <tr><th>Filière:</th><td>{{ $etudiant->groupe->filiere->nom }}</td></tr>
                    <tr><th>Email:</th><td>{{ $etudiant->email ?? '-' }}</td></tr>
                    <tr><th>Téléphone:</th><td>{{ $etudiant->telephone ?? '-' }}</td></tr>
                    <tr><th>Date naissance:</th><td>{{ $etudiant->date_naissance?->format('d/m/Y') ?? '-' }}</td></tr>
                    <tr><th>Statut:</th><td>
                        @if($etudiant->actif)<span class="badge bg-success">Actif</span>
                        @else<span class="badge bg-danger">Inactif</span>@endif
                    </td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.etudiants.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Retour</a>
    <a href="{{ route('admin.etudiants.edit', $etudiant) }}" class="btn btn-warning"><i class="bi bi-pencil me-2"></i> Modifier</a>
</div>
@endsection
