<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bibliothèque')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Contenu principal -->
        <main class="flex-grow">
            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-auto">
            <div class="px-6 py-4 text-center text-sm text-gray-500">
                <p>Bibliothèque - Gestion simplifiée © {{ date('Y') }}</p>
            </div>
        </footer>
    </div>
    
    @stack('scripts')
</body>
</html>