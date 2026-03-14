@extends('layouts.etudiant')

@section('title', 'Mon Tableau de Bord')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-success text-white shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4><i class="bi bi-mortarboard me-2"></i>Bienvenue, {{ auth()->user()->name }}</h4>
                        @if($etudiant && $etudiant->groupe)
                            <p class="mb-0">
                                Groupe: <strong>{{ $etudiant->groupe->nom }}</strong> |
                                Filière: <strong>{{ $etudiant->groupe->filiere->nom }}</strong>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(count($notifications) > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 text-danger"><i class="bi bi-bell-fill me-2"></i>Dernières Notifications</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($notifications as $notif)
                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center bg-light">
                            <div>
                                <i class="bi bi-info-circle-fill text-primary me-2"></i>
                                {!! $notif->data['message'] ?? 'Notification' !!}
                                <br><small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                            </div>
                            <form action="{{ route('notifications.read', $notif->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-link text-secondary p-0" title="Marquer comme lu">
                                    <i class="bi bi-check-all fs-4"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@php $unreadAnnonces = $annonces->filter(fn($a) => !$a->isReadBy(auth()->user())); @endphp
@if($unreadAnnonces->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0 text-primary"><i class="bi bi-megaphone-fill me-2"></i>Annonces</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($unreadAnnonces as $annonce)
                        <div class="list-group-item bg-light">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 fw-bold"><i class="bi bi-pin-angle-fill text-warning me-2"></i>{{ $annonce->titre }}</h6>
                                    <p class="mb-1 text-muted">{!! nl2br(e($annonce->contenu)) !!}</p>
                                </div>
                                <div class="d-flex align-items-center ms-3">
                                    <small class="text-muted text-nowrap me-2">{{ $annonce->created_at->diffForHumans() }}</small>
                                    <form action="{{ route('etudiant.annonces.read', $annonce->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link text-secondary p-0" title="Marquer comme vu">
                                            <i class="bi bi-check-all fs-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-0 text-success"><i class="bi bi-calendar-day me-2"></i>Mes cours d'aujourd'hui</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr><th>Horaire</th><th>Module</th><th>Professeur</th><th>Salle</th></tr>
                </thead>
                <tbody>
                    @forelse($seancesAujourdhui as $seance)
                        <tr class="{{ $seance->is_examen ? 'table-danger' : '' }}">
                            <td>
                                <span class="badge {{ $seance->is_examen ? 'bg-danger' : 'bg-success' }}">
                                    {{ $seance->heure_debut }} - {{ $seance->heure_fin }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ $seance->module->nom }}</strong>
                                @if($seance->is_examen)
                                    <span class="badge bg-danger ms-2">EXAMEN</span>
                                @endif
                            </td>
                            <td>{{ $seance->professeur->nom_complet }}</td>
                            <td>
                                @if($seance->type_seance === 'Teams')
                                    <span class="badge bg-info p-1"><i class="bi bi-laptop me-1"></i>Teams</span>
                                @else
                                    {{ $seance->salle->nom }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-5">Aucun cours aujourd'hui</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        <a href="{{ route('etudiant.emploi') }}" class="btn btn-success px-4">
            <i class="bi bi-calendar3 me-2"></i> Voir mon emploi du temps complet
        </a>
    </div>
</div>
@endsection


