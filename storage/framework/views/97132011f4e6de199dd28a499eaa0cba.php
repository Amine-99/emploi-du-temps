

<?php $__env->startSection('title', 'Professeurs'); ?>
<?php $__env->startSection('subtitle', 'Gestion des professeurs'); ?>

<?php $__env->startSection('actions'); ?>
    <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importModal">
        <i class="bi bi-file-earmark-excel me-2"></i> Importer Excel
    </button>
    <a href="<?php echo e(route('admin.professeurs.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i> Nouveau professeur
    </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Liste des professeurs</h5>
        <form method="GET" class="mt-3 d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Rechercher par nom, prénom, email, téléphone ou spécialité..." value="<?php echo e(request('search')); ?>">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Rechercher
            </button>
            <?php if(request('search')): ?>
                <a href="<?php echo e(route('admin.professeurs.index')); ?>" class="btn btn-secondary ms-2">
                    <i class="bi bi-x-circle"></i> Effacer
                </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Spécialité</th>
                        <th>Heures/mois</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $professeurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $professeur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(($professeurs->currentPage() - 1) * $professeurs->perPage() + $loop->iteration); ?></td>
                            <td>
                                <strong><?php echo e($professeur->prenom); ?> <?php echo e($professeur->nom); ?></strong>
                            </td>
                            <td><?php echo e($professeur->email); ?></td>
                            <td><?php echo e($professeur->telephone ?? '-'); ?></td>
                            <td><?php echo e($professeur->specialite ?? '-'); ?></td>
                            <td>
                                <?php
                                    $heuresActuelles = $professeur->getHeuresMensuellesActuelles();
                                    $maxHeures = $professeur->max_heures_mensuel;
                                ?>
                                <?php if($maxHeures): ?>
                                    <span class="badge <?php echo e($heuresActuelles >= $maxHeures ? 'bg-danger' : ($heuresActuelles >= $maxHeures * 0.7 ? 'bg-warning' : 'bg-info')); ?>">
                                        <?php echo e(\App\Models\EmploiDuTemps::formatHeures($heuresActuelles)); ?> / <?php echo e(\App\Models\EmploiDuTemps::formatHeures($maxHeures)); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">∞</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($professeur->actif): ?>
                                    <span class="badge bg-success">Actif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inactif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('admin.professeurs.show', $professeur)); ?>" class="btn btn-sm btn-outline-primary" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.professeurs.edit', $professeur)); ?>" class="btn btn-sm btn-outline-warning" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.professeurs.destroy', $professeur)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce professeur ?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle me-2"></i>Aucun professeur trouvé
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
    <?php if($professeurs->hasPages()): ?>
        <div class="card-footer px-4 py-3">
            <?php echo e($professeurs->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('admin.professeurs.import')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i class="bi bi-file-earmark-excel me-2"></i>Importer des professeurs
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier Excel (.xlsx, .xls) ou CSV</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls,.csv" required>
                        <div class="form-text mt-2 text-info">
                            <i class="bi bi-info-circle-fill me-1"></i>
                            Un compte utilisateur sera automatiquement créé pour chaque professeur.
                        </div>
                    </div>
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Colonnes attendues :</strong>
                        <ul class="mb-0 mt-2">
                            <li><strong>Mle / Matricule</strong> (Requis)</li>
                            <li>(Supporte <em>Mle Affecté Présentiel/Syn Actif</em>)</li>
                            <li><strong>Nom</strong> & <strong>Prénom</strong> (ou <em>Formateur</em>)</li>
                            <li>(Supporte <em>Formateur Affecté Présentiel/Syn Actif</em>)</li>
                            <li><strong>Groupe</strong> & <strong>Module</strong> (Optionnel - Affectation)</li>
                            <li>Email (Auto-généré si vide)</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload me-2"></i>Importer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\emploi-du-temps\resources\views/admin/professeurs/index.blade.php ENDPATH**/ ?>