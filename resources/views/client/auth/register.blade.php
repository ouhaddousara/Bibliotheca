<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Créer un compte - Bibliothèque</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-100 min-h-screen flex items-center justify-center p-4">
    
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-emerald-600 text-white p-6 text-center">
            <i class="fas fa-user-plus text-5xl mb-3"></i>
            <h1 class="text-2xl font-bold">Créer un compte</h1>
            <p class="text-emerald-200 mt-1"> Rejoignez notre communauté de lecteurs</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-6 mt-4 rounded">
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mx-6 mt-4 rounded">
                <p class="font-semibold">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Registration Form -->
        <div class="p-8">
            <form method="POST" action="{{ route('client.register') }}">
                @csrf

                <!-- Prénom -->
                <div class="mb-4">
                    <label for="firstname" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user mr-2"></i>Prénom *
                    </label>
                    <input 
                        type="text" 
                        id="firstname" 
                        name="firstname" 
                        value="{{ old('firstname') }}" 
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('firstname') border-red-500 @enderror"
                        
                    >
                    @error('firstname')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nom -->
                <div class="mb-4">
                    <label for="lastname" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-user mr-2"></i>Nom *
                    </label>
                    <input 
                        type="text" 
                        id="lastname" 
                        name="lastname" 
                        value="{{ old('lastname') }}" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('lastname') border-red-500 @enderror"
                        
                    >
                    @error('lastname')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope mr-2"></i>Email *
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('email') border-red-500 @enderror"
                        
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Téléphone -->
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-phone mr-2"></i>Téléphone (optionnel)
                    </label>
                    <input 
                        type="text" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                        
                    >
                </div>

                <!-- Adresse -->
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>Adresse (optionnel)
                    </label>
                    <textarea 
                        id="address" 
                        name="address" 
                        rows="2"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                        placeholder="votre adresse">{{ old('address') }}</textarea>
                </div>

                <!-- Mot de passe -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>Mot de passe *
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition @error('password') border-red-500 @enderror"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Minimum 8 caractères avec lettres et chiffres
                    </p>
                </div>

                <!-- Confirmation mot de passe -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>Confirmer le mot de passe *
                    </label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition"
                        placeholder="••••••••"
                    >
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                >
                    <i class="fas fa-user-plus mr-2"></i>Créer mon compte
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">Vous avez déjà un compte ?</p>
                <a href="{{ route('client.login') }}" class="text-emerald-600 hover:text-emerald-800 font-semibold mt-2 block">
                    <i class="fas fa-sign-in-alt mr-1"></i>Se connecter
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-600 border-t">
            
            <p class="mt-1">En créant un compte, vous acceptez nos <a href="#" class="text-emerald-600 hover:text-emerald-800">Conditions d'utilisation</a></p>
        </div>
    </div>

</body>
</html>