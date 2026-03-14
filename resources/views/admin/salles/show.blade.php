@extends('layouts.admin')

@section('title', $salle->nom)
@section('subtitle', 'Détails de la salle')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-building me-2"></i>Informations</h5></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th>Numéro:</th><td><strong>{{ $salle->numero }}</strong></td></tr>
                    <tr><th>Type:</th><td><span class="badge bg-info">{{ $salle->type }}</span></td></tr>
                    <tr><th>Capacité:</th><td>{{ $salle->capacite }} places</td></tr>
                    <tr><th>Bâtiment:</th><td>{{ $salle->batiment ?? '-' }}</td></tr>
                    <tr><th>Équipements:</th><td>{{ $salle->equipements ?? '-' }}</td></tr>
                    <tr><th>Statut:</th><td>
                        @if($salle->disponible)<span class="badge bg-success">Disponible</span>
                        @else<span class="badge bg-danger">Indisponible</span>@endif
                    </td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('admin.salles.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Retour</a>
    <a href="{{ route('admin.salles.edit', $salle) }}" class="btn btn-warning"><i class="bi bi-pencil me-2"></i> Modifier</a>
</div>
@endsection


