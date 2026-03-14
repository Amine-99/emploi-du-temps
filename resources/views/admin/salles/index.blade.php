@extends('layouts.admin')

@section('title', 'Gestion des Salles')

@section('actions')
    <a href="{{ route('admin.salles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i> Nouvelle salle
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Numéro</th>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Capacité</th>
                        <th>Bâtiment</th>
                        <th>Statut</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salles as $salle)
                        <tr>
                            <td><strong>{{ $salle->numero }}</strong></td>
                            <td>{{ $salle->nom }}</td>
                            <td><span class="badge bg-info">{{ $salle->type }}</span></td>
                            <td>{{ $salle->capacite }} places</td>
                            <td>{{ $salle->batiment ?? '-' }}</td>
                             <td>
                                <form action="{{ route('admin.salles.toggle', $salle) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $salle->disponible ? 'btn-success' : 'btn-danger' }}" title="Cliquer pour changer le statut">
                                        {{ $salle->disponible ? 'Disponible' : 'Indisponible' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('admin.salles.show', $salle) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.salles.edit', $salle) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('admin.salles.destroy', $salle) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette salle ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted py-4">Aucune salle trouvée</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($salles->hasPages())
        <div class="card-footer px-4 py-3">
            {{ $salles->links() }}
        </div>
    @endif
</div>
@endsection


