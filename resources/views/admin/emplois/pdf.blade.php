?<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emploi du Temps - {{ $groupe->nom }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { color: #003366; margin: 0; }
        .header h2 { color: #FF6600; margin: 5px 0; }
        .info { margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background-color: #003366; color: white; }
        .horaire { background-color: #f0f0f0; font-weight: bold; width: 80px; }
        .seance { background-color: #e8f4f8; text-align: left; padding: 5px; }
        .seance .module { font-weight: bold; color: #003366; }
        .seance .prof { font-size: 9px; color: #666; }
        .seance .salle { font-size: 9px; color: #888; }
        .footer { margin-top: 20px; text-align: center; font-size: 9px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ISTA M</h1>
        <h2>Emploi du Temps</h2>
    </div>

    <div class="info">
        <strong>Groupe:</strong> {{ $groupe->nom }}<br>
        <strong>Filière:</strong> {{ $groupe->filiere->nom }}<br>
        <strong>Année scolaire:</strong> {{ $groupe->annee_scolaire }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="horaire">Horaire</th>
                @foreach($jours as $jour)
                    <th>{{ $jour }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($creneaux as $heureDebut => $heureFin)
                <tr>
                    <td class="horaire">{{ $heureDebut }}<br>{{ $heureFin }}</td>
                    @foreach($jours as $jour)
                        @php
                            $seance = isset($emplois[$jour])
                                ? $emplois[$jour]->first(function($s) use ($heureDebut) {
                                    return substr($s->heure_debut, 0, 5) == $heureDebut;
                                })
                                : null;
                        @endphp
                        <td class="{{ $seance ? 'seance' : '' }}">
                            @if($seance)
                                <div class="module">{{ $seance->module->nom }}</div>
                                <div class="prof">{{ $seance->professeur->nom_complet }}</div>
                                <div class="salle">{{ $seance->salle->nom }}</div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Généré le {{ now()->format('d/m/Y à H:i') }}
    </div>
</body>
</html>


