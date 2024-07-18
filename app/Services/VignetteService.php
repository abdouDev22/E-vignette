<?php

namespace App\Services;

use App\Models\Voiture;
use App\Models\Vignette;
use App\Models\ApiWaafi;
use App\Models\Achat;
use Illuminate\Support\Facades\DB;

class VignetteService
{
    public function isAccountLocked($user)
    {
        return $user && $user->failed_attempts >= 3 && now()->diffInMinutes($user->last_failed_attempt) < 3;
    }

    public function isValidTransaction($user, $achatVignette, $voiture, $password)
    {
        return $user && $user->solde !== null && $achatVignette && $voiture && $password === $user->password;
    }

    public function incrementFailedAttempts($user)
    {
        $user->increment('failed_attempts');
        $user->last_failed_attempt = now();
        $user->save();
    }

    public function adjustPrices($vignettes, $voiture)
{
    // Implement the logic to adjust prices based on the voiture
    // For example:
    return $vignettes->map(function ($vignette) use ($voiture) {
        $vignette->prix = $this->calculateAdjustedPrice($vignette, $voiture);
        return $vignette;
    });
}


private function calculateAdjustedPrice($vignette, $voiture)
{
    // Implement your price adjustment logic here
    // This is just a placeholder example
    $basePrice = $vignette->prix;
    $adjustment = $voiture->chevaux * 100; // Adjust price based on horsepower
    return $basePrice + $adjustment;
}



    public function processTransaction($user, $prix, $userId, $id_voiture, $id_vignette, $id_mode)
    {
        $user->decrement('solde', $prix);
        $user->failed_attempts = 0;
        $user->last_failed_attempt = null;
        $user->save();

        Achat::create([
            'Date' => now(),
            'prix' => $prix,
            'id_mode_paiement' => $id_mode,
            'id_voiture' => $id_voiture,
            'id_vignette' => $id_vignette,
            'id_code_q_r' => 1,
            'id_client' => $userId
        ]);
    }
}
