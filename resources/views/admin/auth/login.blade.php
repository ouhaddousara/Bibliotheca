<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔐 Connexion Administrateur - Bibliothèque</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    
    <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-indigo-600 text-white p-6 text-center">
            <i class="fas fa-shield-alt text-5xl mb-3"></i>
            <h1 class="text-2xl font-bold">Espace Administrateur</h1>
            <p class="text-indigo-200 mt-1">🔐 Gestion de la bibliothèque</p>
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

        <!-- Login Form -->
        <div class="p-8">
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">
                        <i class="fas fa-envelope mr-2"></i>Votre Email
                    </label>
                    <div class="relative">
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="admin@biblio.fr"
                        >
                        <i class="fas fa-envelope absolute right-3 top-3 text-gray-400"></i>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
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
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            placeholder="••••••••"
                        >
                        <i class="fas fa-lock absolute right-3 top-3 text-gray-400"></i>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember" 
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 text-gray-700 text-sm">
                        Se souvenir de moi
                    </label>
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-indigo-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-indigo-700 transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>Accéder à mon espace
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('client.login') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    <i class="fas fa-user mr-1"></i>Espace Adhérent
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-8 py-4 text-center text-sm text-gray-600 border-t">
            <p> <strong>Bibliothèque</strong> - Gestion simplifiée</p>
            <p class="mt-1">Besoin d'aide ? <a href="mailto:biblio@contact.fr" class="text-indigo-600 hover:text-indigo-800">Contactez-nous</a></p>
        </div>
    </div>

</body>
</html>