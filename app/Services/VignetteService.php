<?php

namespace App\Services;

use App\Models\Voiture;
use App\Models\Vignette;
use App\Models\ApiWaafi;
use App\Models\Achat;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionComplete;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
    if ($user) {
        $user->increment('failed_attempts');
        $user->last_failed_attempt = now();
        $user->save();
    }
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

public function calculatePrice(Voiture $voiture, Vignette $vignette)
{
    // Implement your price calculation logic here
    // This is just a placeholder example
    $basePrice = $vignette->prix;
    $adjustment = $voiture->chevaux * 100; // Adjust price based on horsepower
    return $basePrice + $adjustment;
}




public function processTransaction($user, $prix, $userId, $id_voiture, $id_vignette, $id_mode)
{
    try {
        if (!$user->decrement('solde', $prix)) {
            throw new \Exception('Failed to update user balance');
        }

        $user->failed_attempts = 0;
        $user->last_failed_attempt = null;
        if (!$user->save()) {
            throw new \Exception('Failed to update user data');
        }

        $qrContent = "Vignette ID: $id_vignette, User ID: $userId, Vehicle ID: $id_voiture";
        $qrDir = public_path('qrcodes');
        $qrPath = $qrDir . '/' . time() . '.svg';

        if (!File::isDirectory($qrDir)) {
            if (!File::makeDirectory($qrDir, 0755, true)) {
                throw new \Exception('Failed to create QR code directory');
            }
        }

       

         QrCode::format('svg')->generate($qrContent, $qrPath);

       

        try {
            $codeQR = \App\Models\CodeQR::create([
                'contenu' => $qrContent,
                'boolean' => true,
                'fichier_path' => $qrPath,
            ]);
            if (!$codeQR) {
                throw new \Exception('Failed to create QR code record in database');
            }
        } catch (\Exception $e) {
            \Log::error('QR Code Database Insertion Error: ' . $e->getMessage());
            throw new \Exception('Failed to record QR code in database: ' . $e->getMessage());
        }

        $achat = Achat::create([
            'Date' => now(),
            'prix' => $prix,
            'id_mode_paiement' => $id_mode,
            'id_voiture' => $id_voiture,
            'id_vignette' => $id_vignette,
            'id_code_q_r' => $codeQR->id,
            'id_client' => $userId
        ]);
        if (!$achat) {
            throw new \Exception('Failed to create purchase record');
        }

        $user = Auth::user();
        $vignette=Vignette::findOrFail($id_vignette);
        $voiture= Voiture::findOrFail($id_voiture);
            Mail::to($user->email)->send(new TransactionComplete($achat, $qrPath,$vignette,$voiture));
        

        return $achat;
    } catch (\Exception $e) {
        throw new \Exception('Transaction failed: ' . $e->getMessage());
    }
}







}
