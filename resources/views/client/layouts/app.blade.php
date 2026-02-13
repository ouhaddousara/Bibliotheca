<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bibliothèque')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100">
    
    <!-- Sidebar -->
    @if(auth('client')->check())
    <div id="sidebar" class="bg-emerald-800 text-white h-screen fixed left-0 top-0 w-64 flex flex-col">
        <!-- Logo -->
        <div class="p-6 border-b border-emerald-700">
            <div class="flex items-center space-x-3">
                <i class="fas fa-book-reader text-3xl text-white"></i>
                <span class="text-xl font-bold">Ma Bibliothèque</span>
            </div>
            <p class="text-emerald-300 text-sm mt-1">Espace personnel</p>
        </div>

        <!-- Navigation -->
        <nav class="mt-6 px-4 flex-1 overflow-y-auto">
            <a href="{{ route('client.dashboard') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home text-lg"></i>
                <span>Accueil</span>
            </a>
            <a href="{{ route('client.books.index') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('client.books.*') ? 'active' : '' }}">
                <i class="fas fa-book text-lg"></i>
                <span>Livres disponibles</span>
            </a>
            <a href="{{ route('client.loans.index') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('client.loans.*') ? 'active' : '' }}">
                <i class="fas fa-list text-lg"></i>
                <span>Mes emprunts</span>
            </a>
            <a href="{{ route('client.profile') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('client.profile') ? 'active' : '' }}">
                <i class="fas fa-user text-lg"></i>
                <span>Mon profil</span>
            </a>
        </nav>

        <!-- Déconnexion -->
        <div class="px-4 py-4 border-t border-emerald-700">
            <form method="POST" action="{{ route('client.logout') }}" class="w-full">
                @csrf
                <button type="submit" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg text-red-300 hover:text-red-100 w-full text-left transition">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="main-content min-h-screen {{ auth('client')->check() ? 'ml-64' : 'ml-0' }}">
        
        <!-- Top Bar -->
        @if(auth('client')->check())
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between px-6 py-4">
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-600 hover:text-gray-800">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                <!-- Welcome Message -->
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-800">
                        👋 Bonjour, {{ auth('client')->user()->firstname }} !
                    </h1>
                    <p class="text-gray-600 mt-1">Bienvenue dans votre espace personnel</p>
                </div>

                <!-- User Info -->
                <div class="flex items-center space-x-3">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800">{{ auth('client')->user()->firstname }} {{ auth('client')->user()->lastname }}</p>
                        <p class="text-xs text-gray-500">{{ auth('client')->user()->email }}</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr(auth('client')->user()->firstname, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="p-6">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-xl"></i>
                        <p class="font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3 text-xl"></i>
                        <p class="font-semibold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="px-6 py-8 max-w-7xl mx-auto">
                <!-- Section principale du footer -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Section gauche : Ma Bibliothèque -->
                    <div>
                        <div class="flex items-center space-x-3 mb-4">
                            <i class="fas fa-book-reader text-2xl text-emerald-600"></i>
                            <span class="text-xl font-bold text-gray-800">Ma Bibliothèque</span>
                        </div>
                        <p class="text-gray-600 text-sm">
                            Votre culture à portée de main. Découvrez notre collection de livres et profitez de nos services.
                        </p>
                        <div class="mt-4 flex space-x-4">
                            <a href="https://facebook.com" class="text-gray-400 hover:text-emerald-600 transition">
                                <i class="fab fa-facebook-f text-lg"></i>
                            </a>
                            <a href="https://twitter.com" class="text-gray-400 hover:text-emerald-600 transition">
                                <i class="fab fa-twitter text-lg"></i>
                            </a>
                            <a href="https://instagram.com" class="text-gray-400 hover:text-emerald-600 transition">
                                <i class="fab fa-instagram text-lg"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Section droite : Liens utiles et Contact -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Liens utiles -->
                        <div>
                            <h3 class="font-bold text-gray-800 mb-4">Liens utiles</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('client.books.index') }}" class="text-gray-600 hover:text-emerald-600 text-sm transition">Livres disponibles</a></li>
                                <li><a href="{{ route('client.loans.index') }}" class="text-gray-600 hover:text-emerald-600 text-sm transition">Mes emprunts</a></li>
                                <li><a href="{{ route('client.profile') }}" class="text-gray-600 hover:text-emerald-600 text-sm transition">Mon profil</a></li>
                                <li><a href="{{ route('client.dashboard') }}" class="text-gray-600 hover:text-emerald-600 text-sm transition">Tableau de bord</a></li>
                            </ul>
                        </div>
                        
                        <!-- Contact -->
                        <div>
                            <h3 class="font-bold text-gray-800 mb-4">Contact</h3>
                            <ul class="space-y-2 text-gray-600 text-sm">
                                <li class="flex items-start">
                                    <i class="fas fa-map-marker-alt mt-1 mr-2 text-emerald-600"></i>
                                    <span>Avenue Mohammed VI, Tanger 90000, Maroc</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-phone mr-2 text-emerald-600"></i>
                                    <span>+212 7 24 02 88 64</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-envelope mr-2 text-emerald-600"></i>
                                    <span>biblio@contact.fr</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-clock mr-2 text-emerald-600"></i>
                                    <span>Lun-Ven : 9h-18h • Sam : 10h-16h</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Copyright -->
                <div class="border-t border-gray-200 mt-8 pt-6 text-center text-gray-500 text-sm">
                    <p>© {{ date('Y') }} Bibliothèque - Tous droits réservés</p>
                    <p class="mt-1">Application de gestion de bibliothèque </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Mobile Menu Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebar = document.getElementById('sidebar');

            if (mobileMenuButton && sidebar) {
                mobileMenuButton.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 768 && sidebar.classList.contains('open')) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnMenuButton = mobileMenuButton.contains(event.target);

                    if (!isClickInsideSidebar && !isClickOnMenuButton) {
                        sidebar.classList.remove('open');
                    }
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>