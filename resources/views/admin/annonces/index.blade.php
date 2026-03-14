@extends('layouts.admin')

@section('title', 'Gestion des Annonces')
@section('subtitle', 'Annonces envoyées aux stagiaires')

@section('actions')
    <a href="{{ route('admin.annonces.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i> Nouvelle annonce
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Contenu</th>
                        <th>Créée par</th>
                        <th>Date</th>
                        <th width="100">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($annonces as $annonce)
                        <tr>
                            <td><strong>{{ $annonce->titre }}</strong></td>
                            <td>{{ Str::limit($annonce->contenu, 80) }}</td>
                            <td>{{ $annonce->user->name }}</td>
                            <td>{{ $annonce->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.annonces.destroy', $annonce) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette annonce ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Aucune annonce trouvée</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($annonces->hasPages())
        <div class="card-footer px-4 py-3">
            {{ $annonces->links() }}
        </div>
    @endif
</div>
@endsection
