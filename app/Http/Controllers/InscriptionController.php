<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class InscriptionController extends Controller
{
    public function Ajouter(Request $request)
    {
        Log::info('Ajouter method called.');

        // Valider les données du formulaire (dans ce cas, validation des images)
        $validatedData = $request->validate([
            'image1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image2' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        Log::info('Image validation passed.');

        // Récupérer les fichiers des images uploadées
        $image1 = $request->file('image1');
        $image2 = $request->file('image2');

        // Stocker les images dans le dossier temporaire
        $imagePath1 = $image1->store('temp');
        $imagePath2 = $image2->store('temp');

        // Vérifier si les fichiers existent sur les chemins spécifiés
        if (!Storage::exists($imagePath1) || !Storage::exists($imagePath2)) {
            Log::error('One or more images not found at specified path.');
            return redirect()->back()->withErrors(['image_error' => 'Une ou plusieurs images n\'ont pas été correctement téléchargées.']);
        }

        Log::info('Images stored at: ' . $imagePath1 . ' and ' . $imagePath2);

        // Récupérer les chemins complets des images stockées
        $imageFullPath1 = storage_path('app/' . $imagePath1);
        $imageFullPath2 = storage_path('app/' . $imagePath2);

        // Exemple d'envoi de la première image à OCR.space
        $ocrResponse1 = Http::attach(
            'file',
            fopen($imageFullPath1, 'r'),
            $image1->getClientOriginalName() // Nom du fichier avec extension
        )->post('https://api.ocr.space/parse/image', [
            'apikey' => 'K86302905688957', // Remplacez par votre clé API OCR.space
            'language' => 'eng', // Langue de l'OCR (anglais par défaut)
        ]);

        // Exemple d'envoi de la deuxième image à OCR.space
        $ocrResponse2 = Http::attach(
            'file',
            fopen($imageFullPath2, 'r'),
            $image2->getClientOriginalName() // Nom du fichier avec extension
        )->post('https://api.ocr.space/parse/image', [
            'apikey' => 'K86302905688957', // Remplacez par votre clé API OCR.space
            'language' => 'eng', // Langue de l'OCR (anglais par défaut)
        ]);

        // Vérifier si la requête OCR pour la première image a réussi
        if ($ocrResponse1->successful()) {
            // Convertir la réponse en JSON
            $ocrData1 = $ocrResponse1->json();
            // Traitez les résultats de l'OCR pour la première image si nécessaire
            $parsedText1 = isset($ocrData1['ParsedResults'][0]['ParsedText']) ? $ocrData1['ParsedResults'][0]['ParsedText'] : null;
        } else {
            // Gérer les erreurs OCR pour la première image
            $parsedText1 = null;
            Log::error('OCR request failed for image 1 with status: ' . $ocrResponse1->status());
        }

        // Vérifier si la requête OCR pour la deuxième image a réussi
        if ($ocrResponse2->successful()) {
            // Convertir la réponse en JSON
            $ocrData2 = $ocrResponse2->json();
            // Traitez les résultats de l'OCR pour la deuxième image si nécessaire
            $parsedText2 = isset($ocrData2['ParsedResults'][0]['ParsedText']) ? $ocrData2['ParsedResults'][0]['ParsedText'] : null;
        } else {
            // Gérer les erreurs OCR pour la deuxième image
            $parsedText2 = null;
            Log::error('OCR request failed for image 2 with status: ' . $ocrResponse2->status());
        }

        // Retournez la vue avec les données validées, les résultats de l'OCR et les chemins des images
        return view('inscription', [
            'data' => $validatedData,
            'parsedText1' => $parsedText1,
            'parsedText2' => $parsedText2,
            'imagePath1' => $imagePath1,
            'imagePath2' => $imagePath2,
        ]);
    }
}
