<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Espace Stagiaire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('OFPPT_Logo.png') }}">
    <style>
        :root {
            --ofppt-blue: #003366;
            --ofppt-accent: #2e86de;
            --ofppt-green: #28a745;
        }
        body {
            background-color: #f8f9fa;
        }
        .navbar-custom {
            background: linear-gradient(90deg, var(--ofppt-green) 0%, #218838 100%);
        }
        .navbar-custom .navbar-brand {
            color: white;
            font-weight: 700;
        }
        .navbar-custom .nav-link {
            color: rgba(255,255,255,0.9);
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #ffc107;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('etudiant.dashboard') }}">
                <img src="{{ asset('OFPPT_Logo.png') }}" alt="OFPPT Logo" class="me-2" style="height: 35px; width: auto; object-fit: contain;">
                <span>Espace Stagiaire</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('etudiant.dashboard') ? 'active' : '' }}" href="{{ route('etudiant.dashboard') }}">
                            <i class="bi bi-house me-1"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('etudiant.emploi') ? 'active' : '' }}" href="{{ route('etudiant.emploi') }}">
                            <i class="bi bi-calendar3 me-1"></i> Mon Emploi du Temps
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('etudiant.examens.*') ? 'active' : '' }}" href="{{ route('etudiant.examens.index') }}">
                            <i class="bi bi-calendar-check me-1"></i> Mes Examens
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav align-items-center">
                    @php
                        $annoncesNav = \App\Models\Annonce::where('active', true)->latest()->get();
                        $unreadAnnonces = $annoncesNav->filter(fn($a) => !$a->isReadBy(auth()->user()));
                    @endphp
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle hide-arrow p-0 position-relative text-white" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-megaphone-fill fs-5"></i>
                            @if($unreadAnnonces->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark" style="font-size: 0.6rem;">
                                    {{ $unreadAnnonces->count() }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="width: 320px; max-height: 400px; overflow-y: auto;">
                            <li class="px-3 py-2 border-bottom">
                                <h6 class="mb-0"><i class="bi bi-megaphone me-1"></i>Annonces</h6>
                            </li>
                            @forelse($annoncesNav as $ann)
                                @php $isRead = $ann->isReadBy(auth()->user()); @endphp
                                <li class="px-3 py-2 border-bottom {{ !$isRead ? 'bg-light' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="small fw-bold">{{ $ann->titre }}</div>
                                            <div class="text-muted" style="font-size: 0.8rem;">{{ Str::limit($ann->contenu, 80) }}</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">{{ $ann->created_at->diffForHumans() }}</div>
                                        </div>
                                        @if(!$isRead)
                                            <form action="{{ route('etudiant.annonces.read', $ann->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-link text-secondary p-0" title="Marquer comme vu">
                                                    <i class="bi bi-check-all fs-5"></i>
                                                </button>
                                            </form>
                                        @else
                                            <i class="bi bi-check-all text-success fs-5" title="Vu"></i>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="px-3 py-4 text-center text-muted">
                                    <i class="bi bi-megaphone fs-4 d-block mb-2"></i>
                                    Aucune annonce
                                </li>
                            @endforelse
                        </ul>
                    </li>
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle hide-arrow p-0 position-relative text-white" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bell-fill fs-5"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="width: 320px; max-height: 400px; overflow-y: auto;">
                            <li class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Notifications</h6>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-link p-0 text-decoration-none" style="font-size: 0.75rem;">Tout marquer lu</button>
                                    </form>
                                @endif
                            </li>
                            @forelse(auth()->user()->notifications->take(10) as $notification)
                                <li class="px-3 py-2 border-bottom {{ $notification->unread() ? 'bg-light' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="pe-2">
                                            <div class="small fw-bold">{{ $notification->data['message'] ?? 'Notification' }}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">{{ $notification->created_at->diffForHumans() }}</div>
                                        </div>
                                        @if($notification->unread())
                                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-link text-secondary p-0" title="Marquer comme lu">
                                                    <i class="bi bi-check-all fs-5"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </li>
                            @empty
                                <li class="px-3 py-4 text-center text-muted">
                                    <i class="bi bi-bell-slash fs-4 d-block mb-2"></i>
                                    Aucune notification
                                </li>
                            @endforelse
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


