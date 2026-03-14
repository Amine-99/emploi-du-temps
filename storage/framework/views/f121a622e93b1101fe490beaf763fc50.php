

<?php $__env->startSection('title', 'Modifier Salle'); ?>
<?php $__env->startSection('subtitle', $salle->nom); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Modifier la salle</h5></div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.salles.update', $salle)); ?>" method="POST">
                    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="numero" class="form-label">Numéro <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['numero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="numero" name="numero" value="<?php echo e(old('numero', $salle->numero)); ?>" required>
                            <?php $__errorArgs = ['numero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-8">
                            <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo e(old('nom', $salle->nom)); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type); ?>" <?php echo e(old('type', $salle->type) == $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="capacite" class="form-label">Capacité <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="capacite" name="capacite"
                                   value="<?php echo e(old('capacite', $salle->capacite)); ?>" min="1" required>
                        </div>
                        <div class="col-md-4">
                            <label for="batiment" class="form-label">Bâtiment</label>
                            <input type="text" class="form-control" id="batiment" name="batiment" value="<?php echo e(old('batiment', $salle->batiment)); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="equipements" class="form-label">Équipements</label>
                        <textarea class="form-control" id="equipements" name="equipements" rows="2"><?php echo e(old('equipements', $salle->equipements)); ?></textarea>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="disponible" name="disponible" value="1"
                                   <?php echo e(old('disponible', $salle->disponible) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="disponible">Salle disponible</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.salles.index')); ?>" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i> Annuler</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-2"></i> Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\emploi-du-temps\resources\views/admin/salles/edit.blade.php ENDPATH**/ ?>