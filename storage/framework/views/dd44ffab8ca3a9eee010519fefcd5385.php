

<?php $__env->startSection('title', 'Emprunts - Bibliothèque'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestion des emprunts</h1>
            <p class="text-gray-600 mt-1">Tous les emprunts de la bibliothèque</p>
        </div>
        <a href="<?php echo e(route('admin.loans.create')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i> Nouvel emprunt
        </a>
    </div>

    <!-- Recherche et filtres -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form method="GET" action="<?php echo e(route('admin.loans.index')); ?>" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="relative flex-1">
                <input 
                    type="text" 
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    placeholder="Rechercher un emprunt..." 
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                <i class="fas fa-search absolute left-3 top-2.5 text-gray-400"></i>
            </div>
            <div class="flex space-x-2">
                <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Tous les statuts</option>
                    <option value="current" <?php echo e(request('status') == 'current' ? 'selected' : ''); ?>>📖 En cours</option>
                    <option value="returned" <?php echo e(request('status') == 'returned' ? 'selected' : ''); ?>>✅ Retournés</option>
                    <option value="overdue" <?php echo e(request('status') == 'overdue' ? 'selected' : ''); ?>>⚠️ En retard</option>
                </select>
                <select name="member" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Tous les adhérents</option>
                    <?php $__currentLoopData = $allMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($m->id); ?>" <?php echo e(request('member') == $m->id ? 'selected' : ''); ?>>
                            <?php echo e($m->firstname); ?> <?php echo e($m->lastname); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </form>
    </div>

    <!-- Tableau des emprunts -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adhérent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exemplaire</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'emprunt</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Échéance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-800 font-bold mr-3">
                                    <?php echo e(strtoupper(substr($loan->member->firstname, 0, 1))); ?>

                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($loan->member->firstname); ?> <?php echo e($loan->member->lastname); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($loan->member->email); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900"><?php echo e($loan->copy->book->title); ?></div>
                            <div class="text-gray-500"><?php echo e($loan->copy->book->author); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($loan->copy->code); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($loan->borrowed_at->format('d/m/Y')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($loan->due_date->format('d/m/Y')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($loan->returned_at): ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ✅ Retourné
                                </span>
                            <?php elseif($loan->due_date->isPast()): ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    ⚠️ En retard (<?php echo e(now()->diffInDays($loan->due_date, false)); ?>j)
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                    📖 En cours
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?php echo e(route('admin.loans.show', $loan)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Détails">
                                <i class="fas fa-eye"></i>
                            </a>
                            <?php if(!$loan->returned_at): ?>
                            <a href="<?php echo e(route('admin.loans.return.form', $loan)); ?>" class="text-amber-600 hover:text-amber-900" title="Retourner">
                                <i class="fas fa-undo"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <i class="fas fa-exchange-alt text-4xl mb-3 text-gray-300"></i>
                                <p>Aucun emprunt trouvé</p>
                                <?php if(request()->anyFilled(['search', 'status', 'member'])): ?>
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
                Affichage de <span class="font-medium"><?php echo e($loans->firstItem()); ?></span> à <span class="font-medium"><?php echo e($loans->lastItem()); ?></span> sur <span class="font-medium"><?php echo e($loans->total()); ?></span> résultats
            </div>
            <div>
                <?php echo e($loans->appends(request()->query())->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\GestionBiblio\resources\views/admin/loans/index.blade.php ENDPATH**/ ?>