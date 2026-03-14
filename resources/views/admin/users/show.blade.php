?@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Détails de l'utilisateur</h4>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Retour</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nom:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Rôle:</strong> {{ $user->role === 'head_admin' ? 'Head Admin' : ucfirst($user->role) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Créé le:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Modifié le:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


