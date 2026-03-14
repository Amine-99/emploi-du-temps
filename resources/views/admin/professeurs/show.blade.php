?@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Détails du Professeur</h4>
                    <a href="{{ route('admin.professeurs.index') }}" class="btn btn-primary">Retour</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Matricule:</strong> {{ $professeur->matricule }}</p>
                            <p><strong>Nom:</strong> {{ $professeur->nom }}</p>
                            <p><strong>Prénom:</strong> {{ $professeur->prenom }}</p>
                            <p><strong>Email:</strong> {{ $professeur->email }}</p>
                            <p><strong>Téléphone:</strong> {{ $professeur->telephone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Spécialité:</strong> {{ $professeur->specialite }}</p>
                            <p><strong>Créé le:</strong> {{ $professeur->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Modifié le:</strong> {{ $professeur->updated_at->format('d/m/Y H:i') }}</p>

                            @php
                                $heuresActuelles = $professeur->getHeuresMensuellesActuelles();
                                $maxHeures = $professeur->max_heures_mensuel;
                                $pourcentage = $maxHeures ? round(($heuresActuelles / $maxHeures) * 100) : 0;
                            @endphp

                            <p><strong><i class="bi bi-clock-history me-1"></i>Max heures / mois:</strong>
                                {{ $maxHeures ? $maxHeures . 'h' : 'Pas de limite' }}
                            </p>

                            @if($maxHeures)
                                <p><strong>Heures utilisées:</strong></p>
                                <div class="progress mb-2" style="height: 25px;">
                                    <div class="progress-bar {{ $pourcentage >= 90 ? 'bg-danger' : ($pourcentage >= 70 ? 'bg-warning' : 'bg-success') }}"
                                         role="progressbar" style="width: {{ min($pourcentage, 100) }}%">
                                        {{ \App\Models\EmploiDuTemps::formatHeures($heuresActuelles) }} / {{ \App\Models\EmploiDuTemps::formatHeures($maxHeures) }} ({{ $pourcentage }}%)
                                    </div>
                                </div>
                                @if($pourcentage >= 90)
                                    <div class="alert alert-danger py-1 px-2 mb-0">
                                        <small><i class="bi bi-exclamation-triangle me-1"></i>Ce professeur est proche ou au-delà de sa limite d'heures!</small>
                                    </div>
                                @endif
                            @else
                                <p><strong>Heures actuelles:</strong> {{ \App\Models\EmploiDuTemps::formatHeures($heuresActuelles) }}/mois</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



