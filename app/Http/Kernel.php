protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'professeur' => \App\Http\Middleware\ProfesseurMiddleware::class,
    'etudiant' => \App\Http\Middleware\EtudiantMiddleware::class, // ✅ ici
];
