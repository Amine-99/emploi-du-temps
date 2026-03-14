@extends('layouts.etudiant')

@section('title', 'Mon Emploi du Temps')

@section('content')
@if($etudiant && $groupe)
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Emploi du temps - {{ $groupe->nom }}</h5>
        <span class="badge bg-success">{{ $groupe->filiere->nom }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="table-success">
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
                                <strong>{{ $heureDebut }}</strong><br>
                                <small class="text-muted">{{ $heureFin }}</small>
                            </td>
                            @foreach($jours as $jour)
                                @php
                                    $seance = isset($emplois[$jour])
                                        ? $emplois[$jour]->first(function($s) use ($heureDebut) {
                                            return substr($s->heure_debut, 0, 5) == $heureDebut;
                                        })
                                        : null;
                                @endphp
                                <td class="p-2 {{ $seance ? ($seance->is_examen ? 'bg-danger bg-opacity-10' : 'bg-info bg-opacity-10') : '' }}">
                                    @if($seance)
                                        <div class="p-2 rounded bg-white shadow-sm border-start border-4 {{ $seance->is_examen ? 'border-danger' : 'border-info' }}">
                                            @if($seance->is_examen)
                                                <span class="badge bg-danger mb-1">EXAMEN</span>
                                            @endif
                                            <strong class="d-block text-primary">{{ $seance->module->nom }}</strong>
                                            <small class="d-block text-muted">
                                                <i class="bi bi-person me-1"></i>{{ $seance->professeur->nom_complet }}
                                            </small>
                                            <small class="d-block text-muted">
                                                @if($seance->type_seance === 'Teams')
                                                    <span class="badge bg-info p-1 mb-1"><i class="bi bi-laptop me-1"></i>Teams</span>
                                                    @if($seance->teams_link)
                                                        <a href="{{ $seance->teams_link }}" target="_blank" class="btn btn-sm btn-primary d-block mt-2 py-0" style="font-size: 0.7rem;">
                                                            <i class="bi bi-camera-video me-1"></i>Rejoindre
                                                        </a>
                                                    @else
                                                        <small class="d-block text-muted mt-1" style="font-size: 0.6rem;">Lien non disponible</small>
                                                    @endif
                                                @else
                                                    <i class="bi bi-building me-1"></i>{{ $seance->salle->nom }}
                                                @endif
                                            </small>
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
<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle me-2"></i>
    Votre profil stagiaire n'est pas encore configuré. Veuillez contacter l'administrateur.
</div>
@endif
@endsection


