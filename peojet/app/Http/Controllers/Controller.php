<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Facades\Http;
 use Illuminate\Support\Facades\Session;

abstract class Controller
{
   




 
     public function showForm()
     {
         return view('register');
     }

     public function saveData(Request $request)
     {
         // Valider les données du formulaire
         $request->validate([
             'email' => 'required|email',
             'password' => 'required|confirmed',
             'id_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
         ]);

         // Récupérer les données de session
         $prenom = Session::get('prenom');
         $apiKey = 'K89310091888957'; // Remplacez par votre clé API OCR.space

         // Vérifier si une image a été téléchargée et encoder en base64
         if ($request->hasFile('id_image')) {
             $image = base64_encode(file_get_contents($request->file('id_image')->path()));
         } else {
             return back()->withErrors(['id_image' => 'Image upload failed']);
         }

         // Envoyer l'image à l'API OCR.space
         $apiUrl = "https://api.ocr.space/parse/image";
         $response = Http::asForm()->post($apiUrl, [
             'apikey' => $apiKey,
             'base64Image' => $image,
             'filetype' => 'JPG',
             'language' => 'fre',
             'OCREngine' => 2
         ]);

         $apiData = $response->json();
         $apitoStr = '';

         // Vérifier si des résultats ont été obtenus de l'API
         if (isset($apiData['ParsedResults'])) {
             $firstResult = $apiData['ParsedResults'][0];
             $apitoStr = $firstResult['ParsedText'];
         } else {
             return back()->withErrors(['api' => 'Aucun texte extrait de l\'image.']);
         }

         $currentDate = date('Y-m-d');

         // Insérer les données dans la table cartenum
        }
}
