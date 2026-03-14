?@extends('layouts.admin')

@section('title', 'Gestion des Examens')
@section('subtitle', 'Liste des examens programmés')

@section('actions')
    <a href="{{ route('admin.examens.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i> Nouvel Examen
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Date & Heure</th>
                        <th>Groupe</th>
                        <th>Module</th>
                        <th>Type</th>
                        <th>Coefficient</th>
                        <th>Salle</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($examens as $examen)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $examen->date->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ substr($examen->heure_debut, 0, 5) }} - {{ substr($examen->heure_fin, 0, 5) }}</small>
                            </td>
                            <td>{{ $examen->groupe->nom }}</td>
                            <td>{{ $examen->module->nom }}</td>
                            <td>
                                <span class="badge bg-{{ $examen->type == 'EFF' ? 'danger' : ($examen->type == 'EFM Régional' ? 'warning' : 'primary') }}">
                                    {{ $examen->type }}
                                </span>
                            </td>
                            <td><span class="badge bg-secondary">x{{ $examen->coefficient }}</span></td>
                            <td>{{ $examen->salle ? $examen->salle->nom : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.examens.edit', $examen) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.examens.destroy', $examen) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet examen ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Aucun examen trouvé</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


