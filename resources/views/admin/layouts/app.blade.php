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
        .sidebar-item {
            transition: all 0.2s ease;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar-item.active {
            background-color: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #6366f1;
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
    <div id="sidebar" class="sidebar bg-indigo-800 text-white h-screen fixed left-0 top-0 w-64 flex flex-col">
        <!-- Logo -->
        <div class="p-6 border-b border-indigo-700">
            <div class="flex items-center space-x-3">
                <i class="fas fa-book-reader text-3xl text-white"></i>
                <span class="text-xl font-bold">Bibliothèque</span>
            </div>
            <p class="text-indigo-300 text-sm mt-1">Administration</p>
        </div>

        <!-- Navigation (prend tout l'espace disponible) -->
        <nav class="mt-6 px-4 flex-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home text-lg"></i>
                <span>Tableau de bord</span>
            </a>

            <a href="{{ route('admin.books.index') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                <i class="fas fa-book text-lg"></i>
                <span>Livres</span>
            </a>

            <a href="{{ route('admin.members.index') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                <i class="fas fa-users text-lg"></i>
                <span>Adhérents</span>
            </a>

            <a href="{{ route('admin.loans.index') }}" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg {{ request()->routeIs('admin.loans.*') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt text-lg"></i>
                <span>Emprunts</span>
            </a>
        </nav>

        <!-- Déconnexion (en bas du sidebar) -->
        <div class="px-4 py-4 border-t border-indigo-700">
            <form method="POST" action="{{ route('admin.logout') }}" class="w-full">
                @csrf
                <button type="submit" class="sidebar-item flex items-center space-x-3 py-3 px-4 rounded-lg text-red-300 hover:text-red-100 w-full text-left transition">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>

        
    </div>

    <!-- Main Content -->
    <div class="main-content min-h-screen {{ auth('admin')->check() ? 'main-content-expanded ml-64' : 'ml-0' }}">
        
        <!-- Top Bar -->
        @if(auth('admin')->check())
        <header class="bg-white shadow-sm">
            <div class="flex items-center justify-between px-6 py-4">
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-600 hover:text-gray-800">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                <!-- Breadcrumb -->
                <div class="flex-1">
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                                    <i class="fas fa-home mr-2"></i>
                                    Accueil
                                </a>
                            </li>
                            @if(Request::segment(2))
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-xs text-gray-400 mx-2"></i>
                                    <span class="text-sm font-medium text-gray-500">{{ ucfirst(Request::segment(2)) }}</span>
                                </div>
                            </li>
                            @endif
                        </ol>
                    </nav>
                </div>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="text-gray-600 hover:text-gray-800">
                            <i class="fas fa-bell text-xl"></i>
                            @if($overdueCount ?? 0 > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $overdueCount ?? 0 }}</span>
                            @endif
                        </button>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">{{ auth('admin')->user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrateur</p>
                        </div>
                        <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}
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

            @if(session('warning'))
                <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                        <p class="font-semibold">{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="px-6 py-4 text-center text-sm text-gray-500">
                <p>Bibliothèque - Gestion simplifiée © {{ date('Y') }}</p>
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