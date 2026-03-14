@extends('layouts.admin')

@section('title', $filiere->nom)
@section('subtitle', 'Détails de la filière')

@section('actions')
    <a href="{{ route('admin.filieres.edit', $filiere) }}" class="btn btn-warning">
        <i class="bi bi-pencil me-2"></i> Modifier
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Code:</th>
                        <td><strong>{{ $filiere->code }}</strong></td>
                    </tr>
                    <tr>
                        <th>Niveau:</th>
                        <td><span class="badge bg-info">{{ $filiere->niveau }}</span></td>
                    </tr>
                    <tr>
                        <th>Durée:</th>
                        <td>{{ $filiere->duree_formation }} ans</td>
                    </tr>
                    <tr>
                        <th>Statut:</th>
                        <td>
                            @if($filiere->active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                    </tr>
                </table>
                @if($filiere->description)
                    <hr>
                    <p class="text-muted mb-0">{{ $filiere->description }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-people me-2"></i>Groupes ({{ $filiere->groupes->count() }})</h5>
                <a href="{{ route('admin.groupes.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> Ajouter
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Année</th>
                                <th>Effectif</th>
                                <th>Année scolaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($filiere->groupes as $groupe)
                                <tr>
                                    <td><a href="{{ route('admin.groupes.show', $groupe) }}">{{ $groupe->nom }}</a></td>
                                    <td>{{ $groupe->annee }}ère année</td>
                                    <td>{{ $groupe->effectif }} stagiaires</td>
                                    <td>{{ $groupe->annee_scolaire }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Aucun groupe</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-journal-text me-2"></i>Modules ({{ $filiere->modules->count() }})</h5>
                <a href="{{ route('admin.modules.create') }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus"></i> Ajouter
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Nom</th>
                                <th>Semestre</th>
                                <th>Masse horaire</th>
                                <th>Coefficient</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($filiere->modules as $module)
                                <tr>
                                    <td><strong>{{ $module->code }}</strong></td>
                                    <td>{{ $module->nom }}</td>
                                    <td><span class="badge bg-secondary">S{{ $module->semestre }}</span></td>
                                    <td>{{ $module->masse_horaire }}h</td>
                                    <td>{{ $module->coefficient }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Aucun module</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.filieres.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i> Retour à la liste
    </a>
</div>
@endsection


