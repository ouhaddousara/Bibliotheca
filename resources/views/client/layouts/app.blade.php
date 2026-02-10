<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bibliothèque - Espace Client') | Bibliothèque</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .sidebar {
            transition: all 0.3s ease;
        }
        .sidebar-collapsed {
            width: 64px;
        }
        .main-content {
            transition: all 0.3s ease;
        }
        .main-content-expanded {
            margin-left: 256px;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #10b981;
        }
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 50;
                height: 100vh;
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    
    <!-- Sidebar -->
    @if(auth('client')->check())
    <div id="sidebar" class="sidebar bg-emerald-800 text-white h-screen fixed left-0 top-0 w-64">
        <!-- Logo -->
        <div class="p-6 border-b border-emerald-700">
            <div class="flex items-center space-x-3">
                <i class="fas fa-book-reader text-3xl text-white"></i>
                <span class="text-xl font-bold">Bibliothèque</span>
            </div>
            <p class="text-emerald-300 text-sm mt-1">Mon espace</p>
        </div>

        <!-- Navigation -->
        <nav class="mt-6 px-4">
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

            <div class="mt-6 pt-6 border-t border-emerald-700">
                <a href="{{ route('client.logout') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg text-red-300 hover:text-red-100">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span>Déconnexion</span>
                </a>
            </div>
        </nav>

        <!-- Footer -->
        <div class="absolute bottom-0 left-0 right-0 p-4 text-center text-xs text-emerald-300 border-t border-emerald-700">
            <p>© {{ date('Y') }} Bibliothèque</p>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="main-content min-h-screen {{ auth('client')->check() ? 'main-content-expanded ml-64' : 'ml-0' }}">
        
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
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">{{ auth('client')->user()->getFullNameAttribute() }}</p>
                            <p class="text-xs text-gray-500">{{ auth('client')->user()->email }}</p>
                        </div>
                        <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth('client')->user()->firstname, 0, 1)) }}
                        </div>
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
            <div class="px-6 py-4 text-center text-sm text-gray-500">
                <p>Bibliothèque - Votre culture à portée de main © {{ date('Y') }}</p>
                <p class="mt-1">📧 biblio@contact.fr | 📞 01 23 45 67 89</p>
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