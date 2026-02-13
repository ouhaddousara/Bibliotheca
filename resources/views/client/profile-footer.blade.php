<!-- Footer de la page de profil -->
<div class="mt-8 pt-8 border-t border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
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
                    <span>123 Rue de la Bibliothèque, 75000 Paris</span>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-phone mr-2 text-emerald-600"></i>
                    <span>01 23 45 67 89</span>
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
    
    <div class="border-t border-gray-200 pt-6 text-center text-gray-500 text-sm">
        <p>© {{ date('Y') }} Bibliothèque - Tous droits réservés</p>
        <p class="mt-1">Application de gestion de bibliothèque développée avec Laravel</p>
    </div>
</div>