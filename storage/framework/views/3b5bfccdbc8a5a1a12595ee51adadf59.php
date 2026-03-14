?

<?php $__env->startSection('title', 'Nouvelle Séance'); ?>
<?php $__env->startSection('subtitle', 'Ajouter une nouvelle séance à l\'emploi du temps'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Informations de la séance</h5></div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.emplois.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-check form-switch p-3 bg-light rounded border">
                                <input class="form-check-input ms-0" type="checkbox" id="is_ramadan" name="is_ramadan" value="1">
                                <label class="form-check-label ms-2 fw-bold" for="is_ramadan">
                                    <i class="bi bi-moon-stars-fill text-primary me-1"></i> Mode Ramadan
                                </label>
                                <small class="text-muted ms-3">Active les horaires spécifiques au mois de Ramadan</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 d-none">
                            <label for="jour" class="form-label">Jour <span class="text-danger">*</span></label>
                            <input type="hidden" name="jour" id="jour" value="<?php echo e(old('jour')); ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="date_debut_validite" class="form-label">Date début <span class="text-danger">*</span></label>
                            <?php
                                $defaultDate = now();
                                if (request('jour')) {
                                    $daysMap = ['Dimanche'=>0, 'Lundi'=>1, 'Mardi'=>2, 'Mercredi'=>3, 'Jeudi'=>4, 'Vendredi'=>5, 'Samedi'=>6];
                                    $targetDay = $daysMap[request('jour')] ?? $defaultDate->dayOfWeek;
                                    if ($defaultDate->dayOfWeek != $targetDay) {
                                        $defaultDate = $defaultDate->next($targetDay);
                                    }
                                }
                            ?>
                            <input type="date" class="form-control <?php $__errorArgs = ['date_debut_validite'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="date_debut_validite" name="date_debut_validite" value="<?php echo e(old('date_debut_validite', $defaultDate->format('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['date_debut_validite'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label for="heure_debut" class="form-label">Heure début <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['heure_debut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="heure_debut" name="heure_debut" required>
                                <option value="">Choisir la date d'abord</option>
                            </select>
                            <?php $__errorArgs = ['heure_debut'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label for="heure_fin" class="form-label">Heure fin <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['heure_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="heure_fin" name="heure_fin" required>
                                <option value="">Choisir début</option>
                            </select>
                            <?php $__errorArgs = ['heure_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="groupe_id" class="form-label">Groupe <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['groupe_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="groupe_id" name="groupe_id" required>
                                <option value="">Sélectionner un groupe</option>
                                <?php $__currentLoopData = $groupes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($groupe->id); ?>" <?php echo e(old('groupe_id', request('groupe_id')) == $groupe->id ? 'selected' : ''); ?>>
                                        <?php echo e($groupe->nom); ?> - <?php echo e($groupe->filiere->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['groupe_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label for="module_id" class="form-label">Module <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['module_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="module_id" name="module_id" required>
                                <option value="">Sélectionner un module</option>
                                <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($module->id); ?>" <?php echo e(old('module_id') == $module->id ? 'selected' : ''); ?>>
                                        <?php echo e($module->code); ?> - <?php echo e($module->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['module_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="professeur_id" class="form-label">Professeur <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['professeur_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="professeur_id" name="professeur_id" required>
                                <option value="">Sélectionner un professeur</option>
                                <?php $__currentLoopData = $professeurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($prof->id); ?>" <?php echo e(old('professeur_id') == $prof->id ? 'selected' : ''); ?>>
                                        <?php echo e($prof->nom_complet); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['professeur_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label for="type_seance" class="form-label">Type de séance <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['type_seance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="type_seance" name="type_seance" required>
                                <option value="Présentiel" <?php echo e(old('type_seance') == 'Présentiel' ? 'selected' : ''); ?>>Présentiel</option>
                                <option value="Teams" <?php echo e(old('type_seance') == 'Teams' ? 'selected' : ''); ?>>Teams</option>
                            </select>
                            <?php $__errorArgs = ['type_seance'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4" id="salle_container">
                            <label for="salle_id" class="form-label">Salle <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['salle_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="salle_id" name="salle_id">
                                <option value="">Choisir</option>
                                <?php $__currentLoopData = $salles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($salle->id); ?>" <?php echo e(old('salle_id') == $salle->id ? 'selected' : ''); ?>>
                                        <?php echo e($salle->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['salle_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const typeSelect = document.getElementById('type_seance');
                            const salleContainer = document.getElementById('salle_container');
                            const salleSelect = document.getElementById('salle_id');

                            function toggleSalle() {
                                if (typeSelect.value === 'Teams') {
                                    salleContainer.classList.add('d-none');
                                    salleSelect.required = false;
                                    salleSelect.value = '';
                                } else {
                                    salleContainer.classList.remove('d-none');
                                    salleSelect.required = true;
                                }
                            }

                            typeSelect.addEventListener('change', toggleSalle);
                            toggleSalle();

                            // Slot switching logic
                            const slots = <?php echo json_encode($slots, 15, 512) ?>;
                            const dateDebutInput = document.getElementById('date_debut_validite');
                            const jourInput = document.getElementById('jour');
                            const ramadanCheck = document.getElementById('is_ramadan');
                            const debutSelect = document.getElementById('heure_debut');
                            const finSelect = document.getElementById('heure_fin');
                            let isFirstLoad = true;

                            function getFrenchDay(dateString) {
                                if (!dateString) return '';
                                const days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                                const date = new Date(dateString);
                                return days[date.getDay()];
                            }

                            function updateSlots() {
                                const jour = getFrenchDay(dateDebutInput.value);
                                if (jourInput) jourInput.value = jour;
                                const isRamadan = ramadanCheck.checked;
                                
                                let currentSlots = [];
                                if (isRamadan) {
                                    currentSlots = (jour === 'Vendredi') ? slots.ramadan_friday : slots.ramadan_standard;
                                } else {
                                    currentSlots = (jour === 'Vendredi') ? slots.friday : slots.standard;
                                }

                                const oldDebut = isFirstLoad ? "<?php echo e(old('heure_debut', request('heure_debut'))); ?>" : debutSelect.value;
                                const oldFin = isFirstLoad ? "<?php echo e(old('heure_fin', request('heure_fin'))); ?>" : finSelect.value;

                                debutSelect.innerHTML = '<option value="">Début</option>';
                                finSelect.innerHTML = '<option value="">Fin</option>';

                                for (const [debut, fin] of Object.entries(currentSlots)) {
                                    const dOpt = document.createElement('option');
                                    dOpt.value = debut;
                                    dOpt.textContent = debut;
                                    if (debut === oldDebut) dOpt.selected = true;
                                    debutSelect.appendChild(dOpt);

                                    const fOpt = document.createElement('option');
                                    fOpt.value = fin;
                                    fOpt.textContent = fin;
                                    if (fin === oldFin) fOpt.selected = true;
                                    finSelect.appendChild(fOpt);
                                }
                                isFirstLoad = false;
                            }

                            dateDebutInput.addEventListener('change', updateSlots);
                            ramadanCheck.addEventListener('change', updateSlots);
                            updateSlots();

                            // Dynamic Filtering based on Groupe
                            const groupeSelect = document.getElementById('groupe_id');
                            const moduleSelect = document.getElementById('module_id');
                            const profSelect = document.getElementById('professeur_id');

                            const INITIAL_MODULE = "<?php echo e(old('module_id', $emploi->module_id ?? '')); ?>";
                            const INITIAL_PROF = "<?php echo e(old('professeur_id', $emploi->professeur_id ?? '')); ?>";

                            async function refreshFilteredData(groupeId, initial = false) {
                                if (!groupeId) return;

                                try {
                                    const response = await fetch(`<?php echo e(route('admin.emplois.filter-data')); ?>?groupe_id=${groupeId}`);
                                    const data = await response.json();

                                    // Update Modules
                                    const currentModule = moduleSelect.value || INITIAL_MODULE;
                                    moduleSelect.innerHTML = '<option value="">Sélectionner un module</option>';
                                    data.modules.forEach(m => {
                                        const opt = document.createElement('option');
                                        opt.value = m.id;
                                        opt.textContent = `${m.code} - ${m.nom}`;
                                        if (m.id == currentModule) opt.selected = true;
                                        moduleSelect.appendChild(opt);
                                    });

                                    // Update Professeurs
                                    const currentProf = profSelect.value || INITIAL_PROF;
                                    profSelect.innerHTML = '<option value="">Sélectionner un professeur</option>';
                                    data.professeurs.forEach(p => {
                                        const opt = document.createElement('option');
                                        opt.value = p.id;
                                        opt.textContent = p.nom_complet;
                                        if (p.id == currentProf) opt.selected = true;
                                        profSelect.appendChild(opt);
                                    });

                                } catch (error) {
                                    console.error('Error fetching filtered data:', error);
                                }
                            }

                            groupeSelect.addEventListener('change', function() {
                                refreshFilteredData(this.value);
                            });

                            // Run once on load if group is pre-selected
                            if (groupeSelect.value) {
                                refreshFilteredData(groupeSelect.value, true);
                            }
                        });
                    </script>

                    <div class="row mb-4">
                        <div class="col-md-6 d-none">
                            <label for="semaine_type" class="form-label">Type de semaine</label>
                            <select class="form-select" id="semaine_type" name="semaine_type">
                                <option value="Toutes" selected>Toutes les semaines</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="date_fin_validite" class="form-label">Date fin validité</label>
                            <input type="date" class="form-control" id="date_fin_validite" name="date_fin_validite" value="<?php echo e(old('date_fin_validite')); ?>">
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="actif" name="actif" value="1" <?php echo e(old('actif', '1') ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="actif">Séance active</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.emplois.index')); ?>" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Annuler</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\emploi-du-temps\resources\views/admin/emplois/create.blade.php ENDPATH**/ ?>