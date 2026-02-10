<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\Loan;
use Illuminate\Database\Seeder;

class CleanupSeeder extends Seeder
{
    public function run(): void
    {
        // Supprimer Jean Dupont et ses emprunts
        $member = Member::where('email', 'jean.dupont@email.fr')->first();
        if ($member) {
            $member->loans()->whereNull('returned_at')->delete();
            $member->delete();
            $this->command->info('✅ Jean Dupont supprimé');
        } else {
            $this->command->warn('⚠️ Jean Dupont non trouvé');
        }

        // Supprimer les emprunts du Petit Prince
        $loans = Loan::whereHas('copy.book', function($q) {
            $q->where('title', 'like', '%Petit Prince%');
        })->get();
        
        foreach ($loans as $loan) {
            $loan->delete();
        }
        
        $this->command->info('✅ Emprunts du Petit Prince supprimés');
    }
}