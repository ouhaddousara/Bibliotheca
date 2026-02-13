

<?php $__env->startSection('title', 'Tableau de bord - Bibliothèque'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tableau de bord</h1>
            <p class="text-gray-600 mt-1">Vue d'ensemble de la bibliothèque</p>
        </div>
        <div class="bg-indigo-50 text-indigo-800 px-5 py-3 rounded-xl text-lg font-semibold flex items-center">
            <i class="fas fa-user mr-2"></i>
            👋 <?php echo e(auth('admin')->user()->name); ?>

        </div>
    </div>

    <!-- Statistiques - CARDS CLIQUABLES (Design exactement comme votre image) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Livres disponibles - CLIQUABLE -->
        <a href="<?php echo e(route('admin.books.index')); ?>" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Exemplaires disponibles</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo e(number_format($stats['available_copies'], 0, ',', ' ')); ?></p>
                    <p class="text-green-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-arrow-up mr-1 text-xs"></i> 
                        <?php echo e(number_format($stats['available_copies'] / max($stats['available_copies'] + $stats['borrowed_copies'], 1) * 100, 1)); ?>% du stock
                    </p>
                </div>
                <div class="bg-indigo-100 text-indigo-600 w-14 h-14 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-book text-2xl"></i>
                </div>
            </div>
        </a>

        <!-- Adhérents actifs - CLIQUABLE -->
        <a href="<?php echo e(route('admin.members.index')); ?>" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Adhérents actifs</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo e(number_format($stats['active_members'], 0, ',', ' ')); ?></p>
                    <p class="text-amber-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-user-plus mr-1 text-xs"></i> 
                        +<?php echo e($stats['new_members']); ?> cette semaine
                    </p>
                </div>
                <div class="bg-emerald-100 text-emerald-600 w-14 h-14 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </a>

        <!-- Emprunts en cours - CLIQUABLE -->
        <a href="<?php echo e(route('admin.loans.index')); ?>" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Emprunts en cours</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2"><?php echo e(number_format($stats['borrowed_copies'], 0, ',', ' ')); ?></p>
                    <p class="text-indigo-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-exchange-alt mr-1 text-xs"></i> 
                        <?php echo e(number_format($stats['borrowed_copies'] / max($stats['available_copies'] + $stats['borrowed_copies'], 1) * 100, 1)); ?>% empruntés
                    </p>
                </div>
                <div class="bg-amber-100 text-amber-600 w-14 h-14 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-hand-holding-book text-2xl"></i>
                </div>
            </div>
        </a>

        <!-- Retards - CLIQUABLE -->
        <a href="<?php echo e(route('admin.loans.index')); ?>" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition cursor-pointer">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Emprunts en retard</p>
                    <p class="text-3xl font-bold text-red-600 mt-2"><?php echo e(number_format($stats['overdue_count'], 0, ',', ' ')); ?></p>
                    <?php if($stats['overdue_count'] > 0): ?>
                    <p class="text-red-600 text-sm mt-1 flex items-center font-semibold">
                        <i class="fas fa-exclamation-triangle mr-1 text-xs"></i> 
                        Actions requises !
                    </p>
                    <?php else: ?>
                    <p class="text-green-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-check-circle mr-1 text-xs"></i> 
                        Aucun retard
                    </p>
                    <?php endif; ?>
                </div>
                <div class="bg-red-100 text-red-600 w-14 h-14 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Section Derniers emprunts (simplifiée comme dans l'image) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-indigo-50">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-history mr-2 text-indigo-600"></i>
                Derniers emprunts (<?php echo e($recentLoans->count()); ?>)
            </h2>
            <p class="text-gray-600 mt-1">Les emprunts les plus récents</p>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DATE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ADHÉRENT</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">LIVRE</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUT</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $recentLoans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($loan->borrowed_at->format('d/m/Y H:i')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($loan->member->firstname); ?> <?php echo e($loan->member->lastname); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($loan->copy->book->title); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($loan->returned_at): ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    ✅ Retourné
                                </span>
                            <?php elseif($loan->due_date->isPast()): ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    ⚠️ En retard
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                                    📖 En cours
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\GestionBiblio\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>