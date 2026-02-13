

<?php $__env->startSection('title', 'Mon profil'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl p-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-emerald-600 font-bold text-3xl">
                    <?php echo e(strtoupper(substr($member->firstname, 0, 1))); ?>

                </div>
                <div>
                    <h1 class="text-3xl font-bold"><?php echo e($member->firstname); ?> <?php echo e($member->lastname); ?></h1>
                    <p class="text-emerald-100 text-lg flex items-center">
                        <i class="fas fa-envelope mr-2"></i><?php echo e($member->email); ?>

                    </p>
                    <?php if($member->phone): ?>
                        <p class="text-emerald-100 flex items-center mt-1">
                            <i class="fas fa-phone mr-2"></i><?php echo e($member->phone); ?>

                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <a href="<?php echo e(route('client.profile.edit')); ?>" class="bg-white text-emerald-600 px-6 py-3 rounded-lg font-semibold hover:bg-emerald-50 transition flex items-center">
                <i class="fas fa-edit mr-2"></i>Modifier le profil
            </a>
        </div>
    </div>

    <!-- Profile Details -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 bg-emerald-50">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-user mr-2 text-emerald-600"></i>
                Informations personnelles
            </h2>
        </div>
        
        <div class="divide-y divide-gray-100">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Adresse email</p>
                        <p class="text-gray-800 font-medium mt-1"><?php echo e($member->email); ?></p>
                    </div>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-medium">
                        <i class="fas fa-check-circle mr-1"></i>Vérifiée
                    </span>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Téléphone</p>
                        <p class="text-gray-800 font-medium mt-1">
                            <?php echo e($member->phone ?? 'Non renseigné'); ?>

                        </p>
                    </div>
                    <?php if($member->phone): ?>
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Actif
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Adresse</p>
                        <p class="text-gray-800 font-medium mt-1 whitespace-pre-line">
                            <?php echo e($member->address ?? 'Non renseignée'); ?>

                        </p>
                    </div>
                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-medium">
                        <i class="fas fa-map-marker-alt mr-1"></i>Personnelle
                    </span>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Statut du compte</p>
                        <p class="text-gray-800 font-medium mt-1 flex items-center">
                            <?php if($member->is_active): ?>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Actif
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-medium">
                                    <i class="fas fa-times-circle mr-1"></i>Inactif
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <span class="text-sm text-gray-500">
                        Adhérent depuis le <?php echo e($member->created_at->format('d/m/Y')); ?>

                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="<?php echo e(route('client.books.index')); ?>" class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-emerald-500 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="bg-emerald-100 text-emerald-600 w-12 h-12 rounded-lg flex items-center justify-center">
                    <i class="fas fa-book text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm font-medium">Explorer</p>
                    <p class="text-lg font-bold text-gray-800">Livres disponibles</p>
                </div>
            </div>
        </a>
        
        <a href="<?php echo e(route('client.loans.index')); ?>" class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-indigo-500 hover:shadow-md transition">
            <div class="flex items-center">
                <div class="bg-indigo-100 text-indigo-600 w-12 h-12 rounded-lg flex items-center justify-center">
                    <i class="fas fa-list text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm font-medium">Consulter</p>
                    <p class="text-lg font-bold text-gray-800">Mes emprunts</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Contact Section -->
    <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-100">
        <div class="flex items-start">
            <div class="bg-emerald-100 text-emerald-600 w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="fas fa-headset text-xl"></i>
            </div>
            <div class="ml-4">
                <h3 class="font-bold text-gray-800">Besoin d'aide ?</h3>
                <p class="text-gray-600 mt-1">
                    Contactez notre équipe de support pour toute question ou problème :
                </p>
                <div class="mt-3 space-y-1">
                    <p class="flex items-center text-gray-700">
                        <i class="fas fa-envelope mr-2 text-emerald-600"></i>
                        <span>biblio@contact.fr</span>
                    </p>
                    <p class="flex items-center text-gray-700">
                        <i class="fas fa-phone mr-2 text-emerald-600"></i>
                        <span>+212 7 24 02 88 64</span>
                    </p>
                    <p class="flex items-center text-gray-700">
                        <i class="fas fa-clock mr-2 text-emerald-600"></i>
                        <span>Lun-Ven : 9h-18h • Sam : 10h-16h</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('client.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\GestionBiblio\resources\views/client/profile.blade.php ENDPATH**/ ?>