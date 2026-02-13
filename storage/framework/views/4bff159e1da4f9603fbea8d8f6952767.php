<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>👋 Connexion Adhérent - Bibliothèque</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100 min-h-screen flex items-center justify-center p-4">
    
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-emerald-600 text-white p-6 text-center">
            <i class="fas fa-book-reader text-5xl mb-3"></i>
            <h1 class="text-2xl font-bold">Espace Adhérent</h1>
            <p class="text-emerald-200 mt-1"> Vos emprunts et lectures</p>
        </div>

        <!-- Flash Messages -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4 rounded">
                <p class="font-semibold"><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4 rounded">
                <p class="font-semibold"><?php echo e(session('error')); ?></p>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <div class="p-8">
            <form method="POST" action="<?php echo e(route('client.login')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope mr-2"></i>Votre Email
                    </label>
                    <div class="relative">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="<?php echo e(old('email')); ?>" 
                            required 
                            autofocus
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            placeholder="votre@email.fr"
                        >
                        <i class="fas fa-envelope absolute right-3 top-3 text-gray-400"></i>
                    </div>
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

                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>Votre Mot de passe
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                            placeholder="••••••••"
                        >
                        <i class="fas fa-lock absolute right-3 top-3 text-gray-400"></i>
                    </div>
                    <?php $__errorArgs = ['password'];
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

                <div class="mb-6 flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember" 
                        class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 text-gray-700 text-sm">
                        Se souvenir de moi
                    </label>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-emerald-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-emerald-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>Accéder à mon espace
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="<?php echo e(route('admin.login')); ?>" class="text-emerald-600 hover:text-emerald-800 font-semibold">
                    <i class="fas fa-user-shield mr-1"></i>Espace Administrateur
                </a>
            </div>
        <!-- ... code existant (formulaire de login) ... -->

<!-- Section "Créer un compte" - VERSION MINIMALISTE -->
<div class="mt-8 text-center">
    <div class="inline-flex items-center px-4 py-2 bg-emerald-50 rounded-full mb-4">
        <i class="fas fa-user-plus text-emerald-600 mr-2"></i>
        <span class="text-sm font-semibold text-emerald-800">Nouveau ici ?</span>
    </div>
    
    
    
    <a href="<?php echo e(route('client.register')); ?>" 
       class="inline-flex items-center bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-semibold py-3 px-8 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
        <i class="fas fa-user-plus mr-2"></i>
        Créer un compte gratuit
        <i class="fas fa-arrow-right ml-2 text-sm"></i>
    </a>
    
    <div class="mt-4 flex items-center justify-center space-x-2 text-xs text-gray-500">
        <i class="fas fa-check-circle text-emerald-600"></i>
        <span>Gratuit</span>
        <span>•</span>
        <span>Sécurisé</span>
        <span>•</span>
        <span>Instantané</span>
    </div>
</div>

<!-- ... code existant (footer) ... -->
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-600 border-t">
            <p> <strong>Bibliothèque</strong> - Votre culture à portée de main</p>
            
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\HP\GestionBiblio\resources\views/client/auth/login.blade.php ENDPATH**/ ?>