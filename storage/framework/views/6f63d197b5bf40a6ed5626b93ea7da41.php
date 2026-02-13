

<?php $__env->startSection('title', 'Éditer mon profil'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl p-8 shadow-lg mb-8">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-emerald-600 font-bold text-2xl">
                <?php echo e(strtoupper(substr($member->firstname, 0, 1))); ?>

            </div>
            <div>
                <h1 class="text-2xl font-bold">Éditer mon profil</h1>
                <p class="text-emerald-100 mt-1">Mettez à jour vos informations personnelles</p>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-xl shadow-sm p-8">
        <form method="POST" action="<?php echo e(route('client.profile.update')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <!-- Informations personnelles -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user mr-2 text-emerald-600"></i>
                    Informations personnelles
                </h2>
                <p class="text-gray-600 text-sm mb-6">Ces informations seront affichées sur votre profil public.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Prénom -->
                    <div>
                        <label for="firstname" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user mr-1"></i>Prénom *
                        </label>
                        <input 
                            type="text" 
                            id="firstname" 
                            name="firstname" 
                            value="<?php echo e(old('firstname', $member->firstname)); ?>" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 <?php $__errorArgs = ['firstname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >
                        <?php $__errorArgs = ['firstname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Nom -->
                    <div>
                        <label for="lastname" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-user mr-1"></i>Nom *
                        </label>
                        <input 
                            type="text" 
                            id="lastname" 
                            name="lastname" 
                            value="<?php echo e(old('lastname', $member->lastname)); ?>" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >
                        <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-2">
                        <label for="email" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-envelope mr-1"></i>Email *
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?php echo e(old('email', $member->email)); ?>" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        >
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="phone" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-phone mr-1"></i>Téléphone
                        </label>
                        <input 
                            type="text" 
                            id="phone" 
                            name="phone" 
                            value="<?php echo e(old('phone', $member->phone)); ?>" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"

                        >
                    </div>

                    <!-- Adresse -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i>Adresse
                        </label>
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            ><?php echo e(old('address', $member->address)); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Sécurité -->
            <div class="mb-8 border-t border-gray-200 pt-8">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-lock mr-2 text-emerald-600"></i>
                    Sécurité
                </h2>
                <p class="text-gray-600 text-sm mb-6">Modifiez votre mot de passe pour renforcer la sécurité de votre compte.</p>

                <div class="space-y-4">
                    <!-- Mot de passe actuel -->
                    <div>
                        <label for="current_password" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-key mr-1"></i>Mot de passe actuel
                        </label>
                        <input 
                            type="password" 
                            id="current_password" 
                            name="current_password" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="••••••••"
                        >
                        <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="text-gray-500 text-xs mt-1">Laissez vide si vous ne souhaitez pas modifier le mot de passe</p>
                    </div>

                    <!-- Nouveau mot de passe -->
                    <div>
                        <label for="new_password" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-key mr-1"></i>Nouveau mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="new_password" 
                            name="new_password" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="••••••••"
                        >
                        <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Confirmation nouveau mot de passe -->
                    <div>
                        <label for="new_password_confirmation" class="block text-gray-700 font-semibold mb-2">
                            <i class="fas fa-key mr-1"></i>Confirmer le nouveau mot de passe
                        </label>
                        <input 
                            type="password" 
                            id="new_password_confirmation" 
                            name="new_password_confirmation" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="••••••••"
                        >
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('client.profile')); ?>" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i>Annuler
                </a>
                <button type="submit" class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>

    <!-- Tips Section -->
    <div class="mt-8 bg-emerald-50 border-l-4 border-emerald-500 p-6 rounded-r-xl">
        <h3 class="font-bold text-gray-800 mb-2 flex items-center">
            <i class="fas fa-lightbulb mr-2 text-emerald-600"></i>Conseils pour sécuriser votre compte
        </h3>
        <ul class="text-gray-700 space-y-2 text-sm">
            <li>• Utilisez un mot de passe fort avec au moins 8 caractères, des lettres, des chiffres et des symboles</li>
            <li>• Ne partagez jamais votre mot de passe avec personne</li>
            <li>• Changez régulièrement votre mot de passe pour plus de sécurité</li>
            <li>• Utilisez un email personnel que vous consultez régulièrement</li>
        </ul>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Afficher/masquer le champ mot de passe actuel quand nouveau mot de passe est rempli
document.addEventListener('DOMContentLoaded', function() {
    const newPassword = document.getElementById('new_password');
    const currentPassword = document.getElementById('current_password');
    const currentPasswordLabel = currentPassword.closest('div').querySelector('label');
    
    if (newPassword && currentPassword) {
        newPassword.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                currentPassword.required = true;
                currentPassword.closest('div').classList.remove('opacity-50');
                currentPasswordLabel.innerHTML = currentPasswordLabel.innerHTML.replace('(optionnel)', '(obligatoire)');
            } else {
                currentPassword.required = false;
                currentPassword.closest('div').classList.add('opacity-50');
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('client.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\GestionBiblio\resources\views/client/profile-edit.blade.php ENDPATH**/ ?>