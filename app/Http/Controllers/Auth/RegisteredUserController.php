<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\voitureNNis; // Assurez-vous d'importer votre modèle de table Voiture_NNIs
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        // Récupérer toutes les informations stockées dans la session
        $ocrData = $request->session()->get('ocrData');

        // Réinitialiser les données extraites dans la session
        $request->session()->forget('ocrData');

        return view('auth.register', compact('ocrData'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'image1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Traitement de l'image 1
        $image1 = $request->file('image1');
        $imagePath1 = $image1->store('temp');
        $imageFullPath1 = storage_path('app/' . $imagePath1);
        $ocrResponse1 = Http::attach(
            'file',
            fopen($imageFullPath1, 'r'),
            $image1->getClientOriginalName()
        )->post('https://api.ocr.space/parse/image', [
            'apikey' => 'K86302905688957', // Remplacez par votre clé API OCR.space
            'language' => 'eng',
        ]);
        $ocrData1 = $ocrResponse1->successful() ? $ocrResponse1->json() : null;
        $parsedText1 = is_array($ocrData1) && isset($ocrData1['ParsedResults'][0]['ParsedText']) ? $ocrData1['ParsedResults'][0]['ParsedText'] : 'OCR failed for image 1';

        // Traitement de l'image 2
        $image2 = $request->file('image2');
        $imagePath2 = $image2->store('temp');
        $imageFullPath2 = storage_path('app/' . $imagePath2);
        $ocrResponse2 = Http::attach(
            'file',
            fopen($imageFullPath2, 'r'),
            $image2->getClientOriginalName()
        )->post('https://api.ocr.space/parse/image', [
            'apikey' => 'K86302905688957', // Remplacez par votre clé API OCR.space
            'language' => 'eng',
        ]);
        $ocrData2 = $ocrResponse2->successful() ? $ocrResponse2->json() : null;
        $parsedText2 = is_array($ocrData2) && isset($ocrData2['ParsedResults'][0]['ParsedText']) ? $ocrData2['ParsedResults'][0]['ParsedText'] : 'OCR failed for image 2';

        // Vérifiez que les résultats OCR sont des chaînes
        if (!is_string($parsedText1) || !is_string($parsedText2)) {
            Log::error('Les résultats OCR doivent être des chaînes de caractères.');
            return redirect()->route('register')->with('error', 'Erreur lors du traitement des images OCR.');
        }

        // Log des résultats OCR
        Log::info('OCR Text 1: ' . $parsedText1);
        Log::info('OCR Text 2: ' . $parsedText2);

        // Extraire le nom, l'adresse et le NNI de l'identité à partir du texte OCR
        $identityName = $this->extractIdentityName($parsedText1, $parsedText2);
        $identityAddress = $this->extractIdentityAddress($parsedText1, $parsedText2);
        $identityNNI = $this->extractIdentityNNI($parsedText1, $parsedText2);

        // Stocker toutes les informations dans la session
        $request->session()->put('ocrData', [
            'text1' => $parsedText1,
            'text2' => $parsedText2,
            'identityName' => $identityName,
            'identityAddress' => $identityAddress,
            'identityNNI' => $identityNNI, // Ajouter le NNI aux données stockées
        ]);

        // Vérifiez les données
        if ($this->verifyData($request, $identityName, $identityNNI)) {
            // Stocker les données utilisateur dans la session
            session()->put('userData', [
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'address' => $identityAddress,
                'NNIclient' => $identityNNI,
                'password' => Hash::make($validatedData['password']), // Assurez-vous de hacher le mot de passe
            ]);

            // Envoi du mail avec le code de vérification
            $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT); // Générer un code de vérification numérique de 6 chiffres
            $email = $validatedData['email'];

            Mail::to($email)->send(new VerificationCodeMail($verificationCode));

            // Stocker le code de vérification dans la session
            session()->put('verificationCode', $verificationCode);

            // Rediriger vers la page de vérification
            return redirect()->route('verify-email');
        } else {
            return redirect()->route('register')->with('error', 'Les informations ne correspondent pas. Veuillez vérifier.');
        }
    }

    /**
     * Verify extracted data against form data and database records.
     *
     * @param Request $request
     * @param string $identityName
     * @param string $identityNNI
     * @return bool
     */
    private function verifyData(Request $request, string $identityName, string $identityNNI): bool
    {
        // Compare the extracted name with the form name
        $formName = $request->input('name');
        if (strcasecmp(trim($identityName), trim($formName)) !== 0) {
            Log::error('Nom extrait ne correspond pas au nom du formulaire.');
            return false;
        }

        // Check if the extracted NNI exists in the database
        $existsInDatabase = voitureNNis::where('NNIclient', $identityNNI)->exists();
        if (!$existsInDatabase) {
            Log::error('NNI extrait ne correspond pas aux NNI dans la base de données.');
            return false;
        }

        return true;
    }

      /**
 * Extract the identity name from the OCR texts.
 *
 * @param string $text1
 * @param string $text2
 * @return string
 */
private function extractIdentityName(string $text1, string $text2): string
{
    // Vérifiez que les variables sont des chaînes
    if (!is_string($text1) || !is_string($text2)) {
        Log::error('Les arguments doivent être des chaînes de caractères.');
        return 'Nom non trouvé';
    }

    // Expression régulière pour extraire le nom après "CARTE D'IDENTITÉ"
    $namePattern = '/CARTE D\'IDENTITÉ\s+([^\n]+)/i';
    Log::info('Recherche du nom dans text1: ' . $text1);
    Log::info('Recherche du nom dans text2: ' . $text2);

    if (preg_match($namePattern, $text1, $matches) || preg_match($namePattern, $text2, $matches)) {
        // Nom peut inclure des lignes supplémentaires, donc on extrait le premier groupe
        $name = trim($matches[1] ?? 'Nom non trouvé');
        Log::info('Nom extrait: ' . $name);
        return $name;
    }

    Log::error('Nom non trouvé dans les textes OCR.');
    return 'Nom non trouvé';
}
/**
 * Extract the identity address from the OCR texts.
 *
 * @param string $text1
 * @param string $text2
 * @return string
 */
private function extractIdentityAddress(string $text1, string $text2): string
{
    // Vérifiez que les variables sont des chaînes
    if (!is_string($text1) || !is_string($text2)) {
        Log::error('Les arguments doivent être des chaînes de caractères.');
        return 'Adresse non trouvée';
    }

    // Expression régulière pour extraire l'adresse après "Domicile" ou "Lieu de Naissance"
    $addressPattern = '/(?:Domicile|Lieu de Naissance)\s+([^\n]+)/i';
    Log::info('Recherche de l\'adresse dans text1: ' . $text1);
    Log::info('Recherche de l\'adresse dans text2: ' . $text2);

    if (preg_match($addressPattern, $text1, $matches) || preg_match($addressPattern, $text2, $matches)) {
        // Adresse peut inclure des lignes supplémentaires, donc on extrait le premier groupe
        $address = trim($matches[1] ?? 'Adresse non trouvée');
        Log::info('Adresse extraite: ' . $address);
        return $address;
    }

    Log::error('Adresse non trouvée dans les textes OCR.');
    return 'Adresse non trouvée';
}


/**
 * Extract the National Identifiant (NNI) from the OCR texts using multiple patterns.
 *
 * @param string $text1
 * @param string $text2
 * @return string
 */
private function extractIdentityNNI(string $text1, string $text2): string
{
    // Assurez-vous que les arguments sont des chaînes de caractères
    if (!is_string($text1) || !is_string($text2)) {
        Log::error('Les arguments doivent être des chaînes de caractères.');
        return 'NNI non trouvé';
    }

    // Array of patterns to try
    $patterns = [
        '/Numéro\s+National\s+d\'\s*Identifiant\s*\(NNI\)\s*[:\s]*(\d{12})/i',
        '/NNI\s*[:\s]*(\d{12})/i',
        '/Numéro\s+National\s+d\'\s*Identifiant\s*:\s*(\d{12})/i',
        '/Numéro\s+National\s+d\'\s*Identifiant\s*\(NNI\)\s*:\s*(\d{12})/i',
        '/Numéro\s+National\s+d\'\s*Identifiant\s*[:\s]*(\d{12})/i'
    ];

    foreach ($patterns as $pattern) {
        Log::info('Recherche du NNI avec le modèle: ' . $pattern);
        if (preg_match($pattern, $text1, $matches) || preg_match($pattern, $text2, $matches)) {
            $nni = trim($matches[1] ?? 'NNI non trouvé');
            Log::info('NNI extrait: ' . $nni);
            return $nni;
        }
    }

    Log::error('NNI non trouvé dans les textes OCR.');
    return 'NNI non trouvé';

    
}


}