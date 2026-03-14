?@extends('layouts.admin')

@section('title', 'Détails de la Séance')
@section('subtitle', $emploi->jour . ' ' . $emploi->heure_debut . ' - ' . $emploi->heure_fin)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Informations de la séance</h5></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr><th>Jour:</th><td><span class="badge bg-primary fs-6">{{ $emploi->jour }}</span></td></tr>
                            <tr><th>Horaire:</th><td>{{ $emploi->heure_debut }} - {{ $emploi->heure_fin }}</td></tr>
                            <tr><th>Groupe:</th><td>{{ $emploi->groupe->nom }}</td></tr>
                            <tr><th>Filière:</th><td>{{ $emploi->groupe->filiere->nom }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr><th>Module:</th><td>{{ $emploi->module->nom }}</td></tr>
                            <tr><th>Professeur:</th><td>{{ $emploi->professeur->nom_complet }}</td></tr>
                            <tr>
                                <th>Salle:</th>
                                <td>
                                    @if($emploi->type_seance === 'Teams')
                                        <span class="badge bg-info">Distance (Teams)</span>
                                        @if($emploi->teams_link)
                                            <div class="mt-2">
                                                <a href="{{ $emploi->teams_link }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-link-45deg"></i> Ouvrir le lien
                                                </a>
                                            </div>
                                        @endif
                                    @elseif($emploi->salle)
                                        {{ $emploi->salle->nom }} ({{ $emploi->salle->type }})
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr><th>Semaine:</th><td>{{ $emploi->semaine_type }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 text-center">
    <a href="{{ route('admin.emplois.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Retour</a>
    <a href="{{ route('admin.emplois.edit', $emploi) }}" class="btn btn-warning"><i class="bi bi-pencil me-2"></i> Modifier</a>
</div>
@endsection


