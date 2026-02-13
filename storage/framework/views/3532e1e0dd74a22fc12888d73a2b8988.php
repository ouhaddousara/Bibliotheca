

<?php $__env->startSection('title', 'Mes emprunts'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-800"> Mes emprunts</h1>
        <p class="text-gray-600 mt-2">Consultez l'historique de vos emprunts et leur statut actuel</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500">
            <p class="text-gray-500 text-sm font-medium mb-2">Emprunts en cours</p>
            <p class="text-3xl font-bold text-gray-800"><?php echo e($stats['active']); ?></p>
            <p class="text-sm text-gray-600 mt-2">
                <i class="fas fa-book-reader mr-1"></i>En cours de lecture
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <p class="text-gray-500 text-sm font-medium mb-2">Emprunts retournés</p>
            <p class="text-3xl font-bold text-gray-800"><?php echo e($stats['returned']); ?></p>
            <p class="text-sm text-gray-600 mt-2">
                <i class="fas fa-check-circle mr-1"></i>Livres retournés
            </p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <p class="text-gray-500 text-sm font-medium mb-2">Emprunts en retard</p>
            <p class="text-3xl font-bold text-red-600"><?php echo e($stats['overdue']); ?></p>
            <p class="text-sm text-gray-600 mt-2">
                <i class="fas fa-exclamation-triangle mr-1"></i>
                <?php if($stats['overdue'] > 0): ?>
                    Merci de rapporter !
                <?php else: ?>
                    Tout est à jour
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Overdue Warning -->
    <?php if($stats['overdue'] > 0): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-xl">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-3xl text-red-600 mt-1 mr-4"></i>
                <div>
                    <h3 class="font-bold text-xl text-gray-800 flex items-center">
                        <span class="mr-2">⚠️</span> 
                        Vous avez <?php echo e($stats['overdue']); ?> emprunt(s) en retard !
                    </h3>
                    <p class="mt-2 text-gray-700">
                        Merci de rapporter ces livres dès que possible pour éviter des frais de retard.
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Loans Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'emprunt</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Échéance</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Retour</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($loan->copy->book->title); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e($loan->copy->book->author); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($loan->borrowed_at->format('d/m/Y')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($loan->due_date->format('d/m/Y')); ?>

                            <?php if($loan->due_date->isPast() && !$loan->returned_at): ?>
                                <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 rounded text-xs">
                                    ⚠️ <?php echo e(now()->diffInDays($loan->due_date, false)); ?>j de retard
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php if($loan->returned_at): ?>
                                <?php echo e($loan->returned_at->format('d/m/Y')); ?>

                            <?php else: ?>
                                <span class="text-gray-400">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($loan->returned_at): ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>Retourné
                                </span>
                            <?php elseif($loan->due_date->isPast()): ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    <i class="fas fa-clock mr-1"></i>En retard
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                    <i class="fas fa-book-reader mr-1"></i>En cours
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <i class="fas fa-book-reader text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Aucun emprunt pour le moment</h3>
                            <p class="text-gray-600">Vous n'avez pas encore effectué d'emprunts. Commencez à explorer notre collection de livres !</p>
                            <a href="<?php echo e(route('client.books.index')); ?>" class="mt-4 inline-flex items-center px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                                <i class="fas fa-book mr-2"></i>Découvrir les livres
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($loans->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($loans->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\GestionBiblio\resources\views/client/loans/index.blade.php ENDPATH**/ ?>