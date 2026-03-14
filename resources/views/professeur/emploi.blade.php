@extends('layouts.professeur')

@section('title', 'Mon Emploi du Temps')

@section('content')
@if($professeur)
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Mon emploi du temps</h5>
        <span class="badge bg-info">{{ $professeur->nom_complet }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="100">Horaire</th>
                        @foreach($jours as $jour)
                            <th class="text-center">{{ $jour }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($creneaux as $heureDebut => $heureFin)
                        <tr>
                            <td class="align-middle text-center bg-light">
                                <strong>{{ $heureDebut }}</strong><br>
                                <small class="text-muted">{{ $heureFin }}</small>
                            </td>
                            @foreach($jours as $jour)
                                @php
                                    $seance = isset($emplois[$jour])
                                        ? $emplois[$jour]->first(function($s) use ($heureDebut) {
                                            return substr($s->heure_debut, 0, 5) == $heureDebut;
                                        })
                                        : null;
                                @endphp
                                @php
                                    $isAnnulee = $seance && !$seance->actif && $seance->statut_approbation === 'approved';
                                @endphp
                                <td class="p-2 {{ $seance ? ($isAnnulee ? 'bg-secondary bg-opacity-10' : ($seance->is_examen ? 'bg-danger bg-opacity-10' : 'bg-success bg-opacity-10')) : '' }}">
                                    @if($seance)
                                        <div class="p-2 rounded bg-white shadow-sm border-start border-4 {{ $isAnnulee ? 'border-secondary opacity-50' : ($seance->is_examen ? 'border-danger' : 'border-success') }}">
                                            @if($isAnnulee)
                                                <span class="badge bg-secondary mb-1">ANNULÉE</span>
                                            @elseif($seance->is_examen)
                                                <span class="badge bg-danger mb-1">EXAMEN</span>
                                            @endif
                                            <strong class="d-block {{ $isAnnulee ? 'text-secondary text-decoration-line-through' : ($seance->is_examen ? 'text-danger' : 'text-success') }}">{{ $seance->module->nom }}</strong>
                                            <small class="d-block text-muted">
                                                <i class="bi bi-people me-1"></i>{{ $seance->groupe->nom }}
                                            </small>
                                            <small class="d-block text-muted">
                                                @if($seance->type_seance === 'Teams')
                                                    <span class="badge bg-info p-1"><i class="bi bi-laptop me-1"></i>Teams</span>
                                                @else
                                                    <i class="bi bi-building me-1"></i>{{ $seance->salle->nom }}
                                                @endif
                                            </small>

                                            <div class="mt-2 d-flex flex-wrap gap-1">
                                                @if(!$isAnnulee)
                                                    <form action="{{ route('professeur.emploi.toggle-examen', $seance->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm {{ $seance->is_examen ? 'btn-danger' : 'btn-outline-danger' }} p-1" title="Marquer comme Examen">
                                                            <i class="bi bi-file-earmark-text"></i>
                                                        </button>
                                                    </form>
                                                @php
                                                    $isAujourdhui = $jour === ucfirst(now()->locale('fr')->isoFormat('dddd'));
                                                @endphp

                                                @if($isAujourdhui)
                                                    @if($seance->isRealisee())
                                                        <span class="badge bg-success p-1" title="Séance Validée">
                                                            <i class="bi bi-check-circle"></i>
                                                        </span>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-success p-1" 
                                                                data-bs-toggle="modal" data-bs-target="#modalValiderEmploi{{ $seance->id }}" title="Valider la séance">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>

                                                        <!-- Modal Valider (Unified) -->
                                                        <div class="modal fade" id="modalValiderEmploi{{ $seance->id }}" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg text-start" style="text-align: left !important;">
                                                                <form action="{{ route('professeur.emploi.confirmer', $seance) }}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-content text-dark">
                                                                        <div class="modal-header bg-success text-white">
                                                                            <h5 class="modal-title"><i class="bi bi-check2-square me-2"></i>Validation de la séance</h5>
                                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row mb-3">
                                                                                <div class="col-md-6">
                                                                                    <label class="form-label fw-bold">Session</label>
                                                                                    <p class="mb-0 text-muted">{{ $seance->heure_debut }} - {{ $seance->heure_fin }} | {{ $seance->groupe->nom }}</p>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    @php $availableModules = $seance->getModulesDisponibles(); @endphp
                                                                                    <label class="form-label fw-bold">Module enseigné</label>
                                                                                    <select name="module_id" class="form-select @if($availableModules->count() > 1) border-primary @endif" onchange="toggleSyllabus(this, '{{ $seance->id }}')">
                                                                                        @foreach($availableModules as $m)
                                                                                            <option value="{{ $m->id }}" {{ $m->id == $seance->module_id ? 'selected' : '' }}>
                                                                                                {{ $m->nom }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                                <div class="mb-3">
                                                                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                                                                        <label class="form-label fw-bold small text-start mb-0"><i class="bi bi-book me-2"></i>Chapitres traités aujourd'hui</label>
                                                                                        <button type="button" class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="collapse" data-bs-target="#collapseAddSyllabus{{ $seance->id }}">
                                                                                            <i class="bi bi-plus"></i> Nouveau chapitre
                                                                                        </button>
                                                                                    </div>
                                                                                    
                                                                                    <!-- Formulaire d'ajout rapide de chapitre -->
                                                                                    <div class="collapse mb-3" id="collapseAddSyllabus{{ $seance->id }}">
                                                                                        <div class="card card-body bg-light border-primary border-opacity-25 p-2 shadow-sm">
                                                                                            <div class="row align-items-end g-2">
                                                                                                <div class="col-md-7">
                                                                                                    <label class="form-label small text-muted mb-0">Titre du chapitre</label>
                                                                                                    <input type="text" id="newSyllabusTitle{{ $seance->id }}" class="form-control form-control-sm" placeholder="Ex: Introduction aux bases">
                                                                                                </div>
                                                                                                <div class="col-md-3">
                                                                                                    <label class="form-label small text-muted mb-0">Poids (%)</label>
                                                                                                    <input type="number" id="newSyllabusWeight{{ $seance->id }}" class="form-control form-control-sm" min="0" max="100" value="10">
                                                                                                </div>
                                                                                                <div class="col-md-2 text-end">
                                                                                                    <button type="button" class="btn btn-sm btn-primary w-100" onclick="addSyllabusItem('{{ $seance->id }}')">
                                                                                                        <i class="bi bi-check2"></i>
                                                                                                    </button>
                                                                                                </div>
                                                                                            </div>
                                                                                            <small id="syllabusError{{ $seance->id }}" class="text-danger mt-1 d-none"></small>
                                                                                        </div>
                                                                                    </div>

                                                                                @foreach($availableModules as $m)
                                                                                    <div class="syllabus-container syllabus-module-{{ $m->id }}-{{ $seance->id }}" style="{{ $m->id == $seance->module_id ? '' : 'display:none;' }}">
                                                                                        <div id="syllabusList{{ $m->id }}-{{ $seance->id }}">
                                                                                        @forelse($m->syllabusItems as $item)
                                                                                            <div class="form-check form-check-inline border rounded p-1 mb-1 bg-light small">
                                                                                                <input class="form-check-input ms-0" type="checkbox" name="syllabus_items[]" value="{{ $item->id }}" id="item{{ $item->id }}{{ $seance->id }}">
                                                                                                <label class="form-check-label ms-1" for="item{{ $item->id }}{{ $seance->id }}">
                                                                                                    {{ $item->titre }} <small class="text-muted">({{ $item->poids_pourcentage }}%)</small>
                                                                                                </label>
                                                                                            </div>
                                                                                        @empty
                                                                                            <p class="text-muted small empty-syllabus-msg">Aucun syllabus défini.</p>
                                                                                        @endforelse
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                </div>

                                                                            <hr>
                                                                            <h6 class="mb-3"><i class="bi bi-people me-2"></i>Appel / Présences <small class="text-muted">({{ $seance->groupe->etudiants?->count() ?? 0 }} stagiaires)</small></h6>
                                                                            
                                                                            <div class="table-responsive" style="max-height: 300px;">
                                                                                <table class="table table-sm table-hover border">
                                                                                    <thead class="table-light sticky-top">
                                                                                        <tr>
                                                                                            <th>Stagiaire</th>
                                                                                            <th class="text-center">P</th>
                                                                                            <th class="text-center">A</th>
                                                                                            <th class="text-center">J</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        @if($seance->groupe->etudiants && $seance->groupe->etudiants->count() > 0)
                                                                                            @foreach($seance->groupe->etudiants as $etudiant)
                                                                                                <tr>
                                                                                                    <td>{{ $etudiant->nom_complet }}</td>
                                                                                                    <td class="text-center">
                                                                                                        <input class="form-check-input" type="radio" name="attendance[{{ $etudiant->id }}]" value="Présent" checked>
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <input class="form-check-input" type="radio" name="attendance[{{ $etudiant->id }}]" value="Absent">
                                                                                                    </td>
                                                                                                    <td class="text-center">
                                                                                                        <input class="form-check-input" type="radio" name="attendance[{{ $etudiant->id }}]" value="Justifié">
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        @else
                                                                                            <tr><td colspan="4" class="text-center">Aucun stagiaire répertorié</td></tr>
                                                                                        @endif
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer bg-light">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                            <button type="submit" class="btn btn-success">
                                                                                <i class="bi bi-check-lg me-2"></i>Valider
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                                @if($seance->type_seance === 'Teams')
                                                    <button type="button" class="btn btn-sm btn-outline-info p-1" 
                                                            data-bs-toggle="modal" data-bs-target="#linkModal{{ $seance->id }}" title="Lien de la séance">
                                                        <i class="bi bi-link-45deg"></i>
                                                    </button>
                                                @endif

                                                @if($seance->statut_approbation === 'approved' && $seance->actif)
                                                    <button type="button" class="btn btn-sm btn-outline-warning p-1" 
                                                            data-bs-toggle="modal" data-bs-target="#cancelModal{{ $seance->id }}" title="Demander l'annulation">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>

                                                    <!-- Modal Annulation -->
                                                    <div class="modal fade" id="cancelModal{{ $seance->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content text-start">
                                                                <form action="{{ route('professeur.emploi.cancel', $seance->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Demander l'annulation</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <p>Motif de l'annulation pour <strong>{{ $seance->module->nom }}</strong> :</p>
                                                                        <textarea name="reason" class="form-control" rows="3" required placeholder="Raison de l'annulation (ex: Maladie, Absence prévue)..."></textarea>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                                        <button type="submit" class="btn btn-warning">Envoyer la demande</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($seance->statut_approbation === 'pending')
                                                    <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>En attente</span>
                                                @elseif($seance->statut_approbation === 'rejected')
                                                    <span class="badge bg-danger"><i class="bi bi-x-octagon me-1"></i>Refusé</span>
                                                @endif
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle me-2"></i>
    Votre profil professeur n'est pas encore configuré. Veuillez contacter l'administrateur.
</div>
@endif
<script>
    function toggleSyllabus(select, seanceId) {
        const moduleId = select.value;
        // Masquer tous les containers de cette séance
        document.querySelectorAll(`.syllabus-container[class*="-${seanceId}"]`).forEach(el => {
            el.style.display = 'none';
        });
        // Afficher celui du module sélectionné
        const activeContainer = document.querySelector(`.syllabus-module-${moduleId}-${seanceId}`);
        if (activeContainer) {
            activeContainer.style.display = 'block';
        }
    }

    function addSyllabusItem(seanceId) {
        // Trouver le form contenant ce seanceId pour récupérer le module_id actuellement sélectionné
        const modal = document.getElementById('modalValiderEmploi' + seanceId);
        const moduleId = modal.querySelector('select[name="module_id"]').value;
        
        const titleInput = document.getElementById('newSyllabusTitle' + seanceId);
        const weightInput = document.getElementById('newSyllabusWeight' + seanceId);
        const errorSpan = document.getElementById('syllabusError' + seanceId);
        
        const titre = titleInput.value.trim();
        const poids = weightInput.value;

        if (!titre) {
            errorSpan.textContent = "Le titre est requis.";
            errorSpan.classList.remove('d-none');
            return;
        }

        // Requête AJAX
        fetch(`/professeur/modules/${moduleId}/syllabus`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ titre: titre, poids_pourcentage: poids })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Créer le nouvel élément HTML pour la checkbox
                const listContainer = document.getElementById('syllabusList' + moduleId + '-' + seanceId);
                
                // Supprimer le message "Aucun syllabus défini" s'il existe
                const emptyMsg = listContainer.querySelector('.empty-syllabus-msg');
                if (emptyMsg) emptyMsg.remove();

                const newItemHtml = `
                    <div class="form-check form-check-inline border rounded p-1 mb-1 bg-light small border-success">
                        <input class="form-check-input ms-0" type="checkbox" name="syllabus_items[]" value="${data.item.id}" id="item${data.item.id}${seanceId}" checked>
                        <label class="form-check-label ms-1" for="item${data.item.id}${seanceId}">
                            ${data.item.titre} <small class="text-muted">(${data.item.poids_pourcentage}%)</small>
                            <span class="badge bg-success ms-1" style="font-size: 0.6em;">Nouveau</span>
                        </label>
                    </div>
                `;
                
                listContainer.insertAdjacentHTML('beforeend', newItemHtml);
                
                // Réinitialiser le formulaire
                titleInput.value = '';
                weightInput.value = '10';
                errorSpan.classList.add('d-none');
                
                // Fermer le collapse
                const collapseElement = document.getElementById('collapseAddSyllabus' + seanceId);
                const bsCollapse = bootstrap.Collapse.getInstance(collapseElement);
                if (bsCollapse) bsCollapse.hide();
                
            } else {
                errorSpan.textContent = data.error || "Erreur lors de l'ajout.";
                errorSpan.classList.remove('d-none');
            }
        })
        .catch(error => {
            errorSpan.textContent = "Erreur de connexion.";
            errorSpan.classList.remove('d-none');
        });
    }
</script>
@endsection

{{-- Collect Modals outside table for better rendering --}}
@foreach($emplois as $jourSeances)
    @foreach($jourSeances as $seance)
        <!-- Modal Lien Teams -->
        @if($seance->type_seance === 'Teams')
            <div class="modal fade" id="linkModal{{ $seance->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('professeur.emploi.update-link', $seance->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Lien de la séance (Teams)</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Collez le lien de la réunion pour <strong>{{ $seance->module->nom }}</strong> :</p>
                                <input type="url" name="teams_link" class="form-control" 
                                       value="{{ $seance->teams_link }}" 
                                       placeholder="https://teams.microsoft.com/l/meetup-join/...">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Enregistrer le lien</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @if($seance->statut_approbation === 'approved')
            <!-- Modal Annulation -->
            <div class="modal fade" id="cancelModal{{ $seance->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('professeur.emploi.cancel', $seance->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title">Demander l'annulation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Motif de l'annulation pour <strong>{{ $seance->module->nom }}</strong> :</p>
                                <textarea name="reason" class="form-control" rows="3" required placeholder="Raison de l'annulation (ex: Maladie, Absence prévue)..."></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-warning">Envoyer la demande</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endforeach


