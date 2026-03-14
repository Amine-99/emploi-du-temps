?

<?php $__env->startSection('title', 'Modifier Groupe'); ?>
<?php $__env->startSection('subtitle', $groupe->nom); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Modifier le groupe</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.groupes.update', $groupe)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom du groupe <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="nom" name="nom" value="<?php echo e(old('nom', $groupe->nom)); ?>" required>
                            <?php $__errorArgs = ['nom'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label for="filiere_id" class="form-label">Filière <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['filiere_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="filiere_id" name="filiere_id" required>
                                <?php $__currentLoopData = $filieres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filiere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($filiere->id); ?>" <?php echo e(old('filiere_id', $groupe->filiere_id) == $filiere->id ? 'selected' : ''); ?>>
                                        <?php echo e($filiere->code); ?> - <?php echo e($filiere->nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['filiere_id'];
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
                            <label for="annee" class="form-label">Année <span class="text-danger">*</span></label>
                            <select class="form-select" id="annee" name="annee" required>
                                <option value="1" <?php echo e(old('annee', $groupe->annee) == 1 ? 'selected' : ''); ?>>1ère année</option>
                                <option value="2" <?php echo e(old('annee', $groupe->annee) == 2 ? 'selected' : ''); ?>>2ème année</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="effectif" class="form-label">Effectif</label>
                            <input type="number" class="form-control" id="effectif" name="effectif"
                                   value="<?php echo e(old('effectif', $groupe->effectif)); ?>" min="0">
                        </div>
                        <div class="col-md-4">
                            <label for="annee_scolaire" class="form-label">Année scolaire <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="annee_scolaire" name="annee_scolaire"
                                   value="<?php echo e(old('annee_scolaire', $groupe->annee_scolaire)); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input type="hidden" name="actif" value="0">
                                <input class="form-check-input" type="checkbox" role="switch" id="actif" name="actif" value="1" <?php echo e(old('actif', $groupe->actif) ? 'checked' : ''); ?>>
                                <label class="form-check-label" for="actif">Groupe Actif (affiché dans les listes)</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.groupes.index')); ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i> Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\XAMPP1\htdocs\emploi-du-temps\resources\views/admin/groupes/edit.blade.php ENDPATH**/ ?>