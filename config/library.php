<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Paramètres Métier de la Bibliothèque
    |--------------------------------------------------------------------------
    */

    'loan_period_days' => 14,
    'reminder_days' => 3,

    'status_emojis' => [
        'available' => '🟢',
        'borrowed' => '🟡',
        'overdue' => '🔴⚠️',
        'returned' => '✅',
        'pending' => '⏳',
    ],

    'email_signatures' => [
        'admin' => "L'équipe de la bibliothèque 
        \n*Gérer mes emprunts : [lien]*",
        'reminder' => "Merci pour votre coopération ! 
        \n*Un retard ? Contactez-nous : biblio@contact.fr*"
    ],

    'ux_messages' => [
        'loan_success' => 'Emprunt enregistré ! 📖✨ Profitez bien de votre lecture.',
        'return_success' => 'Retour validé ! ✅ Merci pour votre ponctualité.',
        'overdue_warning' => '⚠️ Attention : Ce livre est en retard de [jours] jours !',
    ],
];