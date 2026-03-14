?@extends('layouts.admin')

@section('title', 'Gestion du Syllabus')
@section('subtitle', 'Module: ' . $module->nom)

@section('actions')
    <a href="{{ route('admin.modules.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i> Retour aux modules
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Ajouter un Chapitre</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.modules.syllabus.store', $module) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Titre du chapitre</label>
                        <input type="text" name="titre" class="form-control" placeholder="Introduction, Algorithmique..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Poids (%)</label>
                        <input type="number" name="poids_pourcentage" class="form-control" value="10" min="1" max="100" required>
                        <small class="text-muted">Part relative du module (ex: 20%)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ordre</label>
                        <input type="number" name="ordre" class="form-control" value="{{ $items->count() + 1 }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description (Optionnel)</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ajouter au syllabus</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-list-ol me-2"></i>Syllabus du Module</h5>
                <span class="badge bg-info text-dark">Total: {{ $items->sum('poids_pourcentage') }}%</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Titre</th>
                                <th>Poids</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>{{ $item->ordre }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $item->titre }}</div>
                                        @if($item->description)
                                            <small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->poids_pourcentage }}%</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('admin.modules.syllabus.destroy', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce chapitre ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                        </form>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.modules.syllabus.update', $item) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Modifier Chapitre</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3 text-start" style="text-align: left !important;">
                                                                <label class="form-label">Titre</label>
                                                                <input type="text" name="titre" class="form-control" value="{{ $item->titre }}" required>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 mb-3 text-start">
                                                                    <label class="form-label">Poids (%)</label>
                                                                    <input type="number" name="poids_pourcentage" class="form-control" value="{{ $item->poids_pourcentage }}" required>
                                                                </div>
                                                                <div class="col-6 mb-3 text-start">
                                                                    <label class="form-label">Ordre</label>
                                                                    <input type="number" name="ordre" class="form-control" value="{{ $item->ordre }}">
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 text-start">
                                                                <label class="form-label">Description</label>
                                                                <textarea name="description" class="form-control" rows="2">{{ $item->description }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">Aucun chapitre défini pour ce module.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


