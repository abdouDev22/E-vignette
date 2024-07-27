<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\voitureNNis;
use App\Models\voiture;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class VerificationController extends Controller
{
    /**
     * Show the form to enter the verification code.
     *
     * @return \Illuminate\View\View
     */
    public function showForm(): \Illuminate\View\View
    {
        return view('auth.verify-code');
    }

    /**
     * Handle the verification code.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function verifyCode(Request $request): RedirectResponse
    {
        // Validation du code de vérification
        $request->validate([
            'verification_code' => 'required|array|size:6', // Assurez-vous que le code est un tableau de 6 chiffres
            'verification_code.*' => 'required|digits:1', // Chaque champ doit être un chiffre unique
        ]);

        // Concaténer les valeurs des champs de code de vérification en une seule chaîne
        $verificationCode = implode('', $request->input('verification_code'));

        // Récupérer le code de vérification stocké en session
        $storedCode = (string) session()->get('verificationCode');

        // Comparer le code fourni avec le code stocké
        if ($verificationCode === $storedCode) {
            // Récupérer les données de l'utilisateur depuis la session
            $userData = session()->get('userData');

            if ($userData) {
                // Insérer les données dans la table users
                $user = new User();
                $user->name = $userData['name'];
                $user->email = $userData['email'];
                $user->address = $userData['address'];
                $user->NNIclient = $userData['NNIclient'];
                $user->email_verified_at = now();
                $user->password = $userData['password'];
                $user->save();

                // Récupérer l'ID de l'utilisateur nouvellement créé
                $userId = $user->id;

                // Insérer les données de Voiture si nécessaire
                $this->insertVoituresFromVoitureNNis($userId, $userData['NNIclient']);

                // Effacer les données utilisateur de la session après l'enregistrement
                session()->forget('userData');
                session()->forget('verificationCode');

                // Rediriger l'utilisateur vers la page de connexion avec un message de succès
                return redirect()->route('login')->with('success', 'Code de vérification correct et Inscription réussie.');
            }

            // Si les données de l'utilisateur ne sont pas disponibles, rediriger avec une erreur
            return redirect()->route('verify-email')->with('error', 'Données utilisateur manquantes.');
        } else {
            // Si le code est incorrect, rediriger vers la page de vérification avec un message d'erreur
            return redirect()->route('verify-email')->with('error', 'Code de vérification incorrect.');
        }
    }

    /**
     * Resend the verification email.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function resendVerificationEmail(Request $request): RedirectResponse
    {
        // Récupérer l'email stocké en session
        $email = $request->session()->get('userData.email');

        if ($email) {
            try {
                // Générer un nouveau code de vérification numérique
                $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $request->session()->put('verificationCode', $verificationCode);

                // Envoyer l'email de vérification
                Mail::to($email)->send(new VerificationCodeMail($verificationCode));

                return redirect()->route('verify-email')->with('status', 'verification-link-sent');
            } catch (\Exception $e) {
                // Journaliser l'exception et rediriger avec un message d'erreur
                Log::error('Erreur lors de l\'envoi de l\'email de vérification: ' . $e->getMessage());
                return redirect()->route('verify-email')->withErrors(['email' => 'Une erreur est survenue lors de l\'envoi de l\'email de vérification.']);
            }
        }

        return redirect()->route('verify-email')->withErrors(['email' => 'Aucune adresse e-mail trouvée pour renvoyer le code.']);
    }

    /**
     * Insert data from VoitureNNis into Voiture based on the NNI.
     *
     * @param int $userId
     * @param string $identityNNI
     */
    private function insertVoituresFromVoitureNNis(int $userId, string $identityNNI)
    {
        // Récupérer les données de voiturennis avec le NNI correspondant
        $voituresNNis = VoitureNNis::where('NNIclient', $identityNNI)->get();

        foreach ($voituresNNis as $voitureNNis) {
            // Créer une nouvelle instance de Voiture
            $voiture = new Voiture();
            $voiture->matricule = $voitureNNis->matricule;
            $voiture->marque = $voitureNNis->marque;
            $voiture->type = $voitureNNis->type;
            $voiture->chevaux = $voitureNNis->chevaux;
            $voiture->id_client = $userId; // Utiliser l'ID de l'utilisateur nouvellement créé

            // Sauvegarder la nouvelle Voiture
            $voiture->save();
        }

        Log::info('Les données de voiturennis avec NNI ' . $identityNNI . ' ont été transférées vers la table voitures.');
    }
}
