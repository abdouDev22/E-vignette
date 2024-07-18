<?php

namespace App\Http\Controllers;

use App\Models\Voiture;
use App\Models\Achat;
use App\Models\Vignette;
use App\Models\ModePaiement;
use App\Models\ApiWaafi;
use App\Http\Requests\AchatVignetteRequest;
use App\Services\VignetteService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BaseContent extends Controller
{
    protected $user;
    protected $vignetteService;

    // Constantes pour le verrouillage du compte
    const MAX_FAILED_ATTEMPTS = 3;
    const LOCK_DURATION_MINUTES = 3;

    /**
     * Constructeur pour injecter les dépendances et configurer le middleware
     */
    public function __construct(VignetteService $vignetteService)
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
        $this->vignetteService = $vignetteService;
    }

    /**
     * Affiche la page d'accueil avec les véhicules de l'utilisateur
     */
    public function welcome()
    {
        $voitures = Voiture::where('id_client', $this->user->id)
            ->select('id', 'matricule', 'chevaux')
            ->get();
        return view('welcome', compact('voitures'));
    }

    /**
     * Affiche les vignettes obtenues pour un véhicule spécifique
     */
    public function vignetteObtenue(Voiture $voiture)
    {
        $achatVignettes = Achat::where('id_client', $this->user->id)
            ->where('id_voiture', $voiture->id)
            ->select('prix', 'Date')
            ->get();
        return view('vigetteObetnu', compact('achatVignettes'));
    }

    /**
     * Affiche la page d'achat de vignette
     */
    public function achatVignette()
    {
        $voitures = Voiture::where('id_client', $this->user->id)
            ->select('id', 'matricule', 'chevaux')
            ->get();
        return view('voitureachat', compact('voitures'));
    }

    /**
     * Affiche les vignettes disponibles pour un véhicule spécifique
     */
    public function vignette(Voiture $voiture)
    {
        $achatVignettes = Vignette::select('id', 'date', 'prix')->get();
        $achatVignettes = $this->vignetteService->adjustPrices($achatVignettes, $voiture);
        return view('achatvignette', compact('achatVignettes', 'voiture'));
    }

    /**
     * Affiche la page de sélection du service
     */
    public function service(Voiture $voiture, Vignette $vignette)
    {
        $mode_paiements = ModePaiement::select('id', 'mode')->get();
        return view('service', compact('voiture', 'vignette', 'mode_paiements'));
    }

    /**
     * Affiche la page du code QR pour le paiement
     */
    public function codeqr(Voiture $voiture, Vignette $vignette, ModePaiement $modePaiement)
    { 
        return view('api.api_waafi_connexion', compact('voiture', 'vignette', 'modePaiement'));
    }

    /**
     * Traite l'achat de la vignette
     */
    public function page_achat(AchatVignetteRequest $request, Voiture $voiture, Vignette $vignette, ModePaiement $modePaiement)
    {
        $user = ApiWaafi::where('tel', $request->phone)->first();

        // Vérifie si le compte est verrouillé
        if ($this->vignetteService->isAccountLocked($user)) {
            return $this->returnErrorView($voiture, $vignette, $modePaiement, __('messages.account_locked'));
        }

        // Valide la transaction
        if (!$this->vignetteService->isValidTransaction($user, $vignette, $voiture, $request->password)) {
            $this->vignetteService->incrementFailedAttempts($user);
            return $this->returnErrorView($voiture, $vignette, $modePaiement, __('messages.invalid_credentials'));
        }

        $prix = $this->vignetteService->calculatePrice($voiture, $vignette);

        // Vérifie si l'utilisateur a un solde suffisant
        if ($user->solde < $prix) {
            return $this->returnErrorView($voiture, $vignette, $modePaiement, __('messages.insufficient_balance'));
        }

        // Traite la transaction
        DB::beginTransaction();
        try {
            $this->vignetteService->processTransaction($user, $prix, $this->user->id, $voiture->id, $vignette->id, $modePaiement->id);
            DB::commit();
            return view('api.api_waafi_affiche', ['id_mode' => $modePaiement->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('La transaction a échoué: ' . $e->getMessage());
            return $this->returnErrorView($voiture, $vignette, $modePaiement, __('messages.transaction_failed'));
        }
    }

    /**
     * Méthode auxiliaire pour retourner la vue d'erreur
     */
    private function returnErrorView($voiture, $vignette, $modePaiement, $error)
    {
        return view('api.api_waafi_connexion', compact('voiture', 'vignette', 'modePaiement', 'error'));
    }
}


