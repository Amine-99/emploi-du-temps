?@extends('layouts.etudiant')

@section('title', 'Mes Examens')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-white bg-opacity-25 p-3 me-3">
                        <i class="bi bi-calendar-check fs-2"></i>
                    </div>
                    <div>
                        <h3 class="mb-1">Examens à Venir</h3>
                        <p class="mb-0 opacity-75">Consultez vos dates d'examens et le temps restant pour vous préparer.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    @forelse($examens as $examen)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-start">
                    <div>
                        <span class="badge bg-{{ $examen->countdown_class }} mb-2 px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-hourglass-split me-1"></i> {{ $examen->countdown }}
                        </span>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-light text-dark border px-2 py-1">
                            Coef: {{ $examen->coefficient }}
                        </span>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    <h5 class="card-title fw-bold text-primary mb-3">{{ $examen->module->nom }}</h5>
                    
                    <div class="d-flex align-items-center mb-2 text-muted">
                        <i class="bi bi-tag-fill me-2"></i>
                        <span>Type: <strong>{{ $examen->type }}</strong></span>
                    </div>

                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-calendar3 me-2 text-secondary"></i>
                        <span class="fw-bold text-dark">{{ $examen->date->format('l d F Y') }}</span>
                    </div>
                    
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-clock me-2 text-secondary"></i>
                        <span>{{ substr($examen->heure_debut, 0, 5) }} - {{ substr($examen->heure_fin, 0, 5) }}</span>
                    </div>

                    <div class="bg-light rounded p-3 d-flex align-items-center">
                        <i class="bi bi-geo-alt-fill me-2 text-danger"></i>
                        <span class="small fw-bold">{{ $examen->salle ? $examen->salle->nom : 'Salle non spécifiée' }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm text-center p-5">
                <div class="card-body">
                    <i class="bi bi-journal-check text-muted mb-3" style="font-size: 3rem;"></i>
                    <h4>Aucun examen programmé</h4>
                    <p class="text-muted">Vous n'avez pas d'examens à venir pour le moment.</p>
                </div>
            </div>
        </div>
    @endforelse
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .transition {
        transition: all 0.3s ease;
    }
</style>
@endsection


