?<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        @page { 
            margin: 0.3cm; 
            size: A3 landscape;
        }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 6pt; 
            color: #000; 
            margin: 0; 
            padding: 0; 
        }
        .header { 
            text-align: center; 
            margin-bottom: 5px; 
            border-bottom: 1px solid #000;
        }
        .header h1 { font-size: 12pt; margin: 0; padding: 0; }
        .header p { margin: 2px 0; font-size: 8pt; font-weight: bold; }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            table-layout: fixed; 
            border: 1px solid #000;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 1px; 
            text-align: center;
            vertical-align: middle;
            overflow: hidden;
        }
        
        /* Headers */
        th { 
            background-color: #333; 
            color: white; 
            font-weight: bold;
        }
        .day-header {
            font-size: 7pt;
            height: 15px;
        }
        .slot-header {
            height: 12px;
            font-size: 5pt;
            background-color: #eee;
            color: #000;
        }
        
        /* Group Column */
        .group-col { 
            width: 25px; 
            background-color: #f0f0f0;
        }
        
        /* Dompdf Rotation Trick */
        .rotated-container {
            width: 25px;
            height: 80px; /* Reduced row height to fit more groups */
            position: relative;
        }
        .rotated-text {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 80px;
            height: 25px;
            margin-left: -40px;
            margin-top: -12px;
            transform: rotate(-90deg);
            font-weight: bold;
            font-size: 7pt;
            text-align: center;
            white-space: nowrap;
        }
        
        /* Cells */
        .matrix-cell {
            height: 80px;
        }
        .empty-cell { 
            background-color: #2c3e50; 
        }
        
        .seance-content {
            width: 100%;
            font-size: 5.5pt;
        }
        .module-code { 
            font-weight: 900; 
            display: block; 
            border-bottom: 0.5px solid #ddd;
            margin-bottom: 2px;
        }
        .prof-name { display: block; font-style: italic; color: #333; }
        .salle-name { font-weight: bold; display: block; color: #0d6efd; margin-top: 2px; }
        
        .teams { background-color: #f0faff; }
        .teams .salle-name { color: #0dcaf0; }
        .examen { background-color: #fff5f5; border: 1.5px solid #dc3545; }

        .footer { 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
            text-align: right; 
            font-size: 5pt; 
            color: #777; 
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>EMPLOI DU TEMPS GLOBAL - {{ $title }}</h1>
        <p>{{ $weekRange }} @if($isRamadan) (MODE RAMADAN) @endif</p>
    </div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" class="group-col" style="width: 25px;">GRP</th>
                @foreach($jours as $jour)
                    @php 
                        $slots = \App\Models\EmploiDuTemps::getCreneaux($jour, $isRamadan);
                        $count = count($slots);
                    @endphp
                    <th colspan="{{ $count }}" class="day-header">
                        {{ strtoupper($jour) }}
                    </th>
                @endforeach
            </tr>
            <tr>
                @foreach($jours as $jour)
                    @php $slots = \App\Models\EmploiDuTemps::getCreneaux($jour, $isRamadan); @endphp
                    @foreach($slots as $debut => $fin)
                        <th class="slot-header">{{ substr($debut, 0, 5) }}</th>
                    @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($groupes as $groupe)
                <tr>
                    <td class="group-col">
                        <div class="rotated-container">
                            <div class="rotated-text">{{ $groupe->nom }}</div>
                        </div>
                    </td>
                    @foreach($jours as $jour)
                        @php 
                            $slots = \App\Models\EmploiDuTemps::getCreneaux($jour, $isRamadan);
                            $slotCount = count($slots);
                        @endphp
                        @for($i = 0; $i < $slotCount; $i++)
                            @php $seance = $emplois[$groupe->id][$jour][$i] ?? null; @endphp
                            <td class="matrix-cell {{ !$seance ? 'empty-cell' : '' }} {{ $seance?->type_seance == 'Teams' ? 'teams' : '' }} {{ $seance?->is_examen ? 'examen' : '' }}">
                                @if($seance)
                                    <div class="seance-content">
                                        <span class="module-code">{{ $seance->module->code ?? $seance->module->nom }}</span>
                                        <span class="prof-name">{{ $seance->professeur->nom }}</span>
                                        <span class="salle-name">
                                            @if($seance->type_seance == 'Teams') TEAMS @else {{ $seance->salle?->nom }} @endif
                                        </span>
                                    </div>
                                @endif
                            </td>
                        @endfor
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Généré le {{ date('d/m/Y H:i') }} | Plateforme de Gestion d'Emploi du Temps
    </div>
</body>
</html>


