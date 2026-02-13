

<?php $__env->startSection('title', 'Adhérents - Bibliothèque'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestion des adhérents</h1>
            <p class="text-gray-600 mt-1">Tous les adhérents de la bibliothèque</p>
        </div>
        <a href="<?php echo e(route('admin.members.create')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i> Ajouter un adhérent
        </a>
    </div>

    <!-- Recherche et filtres -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form method="GET" action="<?php echo e(route('admin.members.index')); ?>" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="relative flex-1">
                <input 
                    type="text" 
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Rechercher un adhérent..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
            </div>
            <div class="flex space-x-2">
                <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Tous les statuts</option>
                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>✅ Actifs</option>
                    <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>⚠️ Inactifs</option>
                </select>
                <select name="date" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Toutes les dates</option>
                    <option value="week" <?php echo e(request('date') == 'week' ? 'selected' : ''); ?>>Cette semaine</option>
                    <option value="month" <?php echo e(request('date') == 'month' ? 'selected' : ''); ?>>Ce mois</option>
                    <option value="year" <?php echo e(request('date') == 'year' ? 'selected' : ''); ?>>Cette année</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Tableau des adhérents -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adhésion</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-800 font-bold mr-3">
                                    <?php echo e(strtoupper(substr($member->firstname, 0, 1))); ?>

                                </div>
                                <div>
                                    <div class="font-medium text-gray-900"><?php echo e($member->firstname); ?> <?php echo e($member->lastname); ?></div>
                                    <div class="text-gray-500 text-sm"><?php echo e($member->email); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($member->email); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($member->phone ?? '—'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($member->created_at->format('d/m/Y')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($member->is_active): ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                    ✅ Actif
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    ⚠️ Inactif
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?php echo e(route('admin.members.show', $member)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('admin.members.edit', $member)); ?>" class="text-amber-600 hover:text-amber-900 mr-3" title="Éditer">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('admin.members.destroy', $member)); ?>" method="POST" class="inline" onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet adhérent ?\n\nCela supprimera également tous ses emprunts en cours.')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                                <p>Aucun adhérent trouvé</p>
                                <?php if(request()->anyFilled(['search', 'status', 'date'])): ?>
                                <p class="mt-2 text-sm text-gray-400">Essayez de modifier les filtres de recherche</p>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Affichage de <span class="font-medium"><?php echo e($members->firstItem()); ?></span> à <span class="font-medium"><?php echo e($members->lastItem()); ?></span> sur <span class="font-medium"><?php echo e($members->total()); ?></span> résultats
            </div>
            <div>
                <?php echo e($members->appends(request()->query())->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\GestionBiblio\resources\views/admin/members/index.blade.php ENDPATH**/ ?>