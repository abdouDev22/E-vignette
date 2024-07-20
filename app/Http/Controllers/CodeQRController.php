<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CodeQRController extends Controller
{
    public function generate(Request $request)
    {
        $content = $request->input('content');

        // Générer le code QR
        $qrCode = QrCode::size(300)->generate($content);

        // Vous pouvez enregistrer le code QR dans un fichier
        $path = public_path('qrcodes/' . time() . '.png');
        QrCode::format('png')->size(300)->generate($content, $path);

        // Ou retourner le code QR en tant que réponse
        return response($qrCode)->header('Content-type','image/png');
    }
}
