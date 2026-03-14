?@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Modifier le Mot de Passe de {{ $user->name }}</h1>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        @if(Auth::id() === $user->id)
            <div class="form-group">
                <label for="current_password">Mot de Passe Actuel</label>
                <input type="password" name="current_password" id="current_password" class="form-control" required>
            </div>
        @endif
        <div class="form-group">
            <label for="password">Nouveau Mot de Passe</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmer le Nouveau Mot de Passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        @if(auth()->user()->role === 'head_admin' && Auth::id() !== $user->id)
            <div class="form-group mt-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="actif" name="actif" value="1"
                           {{ old('actif', $user->actif) ? 'checked' : '' }}>
                    <label class="form-check-label" for="actif">Compte actif</label>
                </div>
            </div>
        @endif
        <button type="submit" class="btn btn-success">Mettre à Jour</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection


