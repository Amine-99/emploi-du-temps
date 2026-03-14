?@extends('layouts.admin')

@section('title', $module->nom)
@section('subtitle', 'Détails du module')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-journal-text me-2"></i>Informations</h5></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th>Code:</th><td><strong>{{ $module->code }}</strong></td></tr>
                    <tr><th>Filières:</th><td>{{ $module->filieres->pluck('nom')->implode(', ') }}</td></tr>
                    <tr><th>Semestre:</th><td><span class="badge bg-info">S{{ $module->semestre }}</span></td></tr>
                    <tr><th>Coefficient:</th><td>{{ $module->coefficient }}</td></tr>
                    <tr>
                        <th><i class="bi bi-clock-history me-1"></i>Module heures:</th>
                        <td>{{ $module->max_heures_mensuel ? \App\Models\EmploiDuTemps::formatHeures($module->max_heures_mensuel) : 'Pas de limite' }}</td>
                    </tr>
                    @php
                        $maxHeures = $module->max_heures_mensuel;
                    @endphp

                    @if($maxHeures)
                        <tr>
                            <th colspan="2" class="pt-4"><i class="bi bi-bar-chart-fill me-2"></i>Utilisation des heures par groupe</th>
                        </tr>
                        @foreach($module->filieres as $filiere)
                            @foreach($filiere->groupes as $groupe)
                                @php
                                    $heuresGroupe = $module->getHeuresMensuellesActuelles(null, $groupe->id);
                                    $pourcentage = round(($heuresGroupe / $maxHeures) * 100);
                                @endphp
                                <tr>
                                    <td colspan="2" class="pb-3">
                                        <div class="d-flex justify-content-between mb-1">
                                            <small>Groupe: <strong>{{ $groupe->nom }}</strong> ({{ $filiere->code }})</small>
                                            <small>{{ \App\Models\EmploiDuTemps::formatHeures($heuresGroupe) }} / {{ \App\Models\EmploiDuTemps::formatHeures($maxHeures) }}</small>
                                        </div>
                                        <div class="progress" style="height: 15px;">
                                            <div class="progress-bar {{ $pourcentage >= 90 ? 'bg-danger' : ($pourcentage >= 70 ? 'bg-warning' : 'bg-success') }}"
                                                 role="progressbar" style="width: {{ min($pourcentage, 100) }}%">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @else
                        <tr><th>Heures totales (Global):</th><td>{{ \App\Models\EmploiDuTemps::formatHeures($module->getHeuresMensuellesActuelles()) }}/mois</td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.modules.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Retour</a>
    <a href="{{ route('admin.modules.edit', $module) }}" class="btn btn-warning"><i class="bi bi-pencil me-2"></i> Modifier</a>
</div>
@endsection


