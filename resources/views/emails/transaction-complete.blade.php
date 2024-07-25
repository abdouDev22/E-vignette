<!DOCTYPE html>
<html>
<head>
    <title>Transaction Complète - Votre E-Vignette</title>
    @vite(['resources/scss/style.scss','resources/js/app.js'])
</head>
<body>
    <h1>Votre transaction est complète</h1>
    <h2 class="span_id">Attention vous devez telecharger un lecteur de SVG pour pouvoir lire le QRcode</h2>
    <p>Cher client,</p>
    <p>Votre achat de vignette électronique a été effectué avec succès.</p>
    <p>Détails de la transaction:</p>
    <ul>
        <li>Date: {{ $achat->Date->format('Y-m-d') }}</li>
        <li>Prix: {{ $achat->prix }}</li>
        <li>Vignette: {{ $vignette->date->format('Y') }}</li>
        <li>Véhicule: {{ $voiture->matricule }}</li>
    </ul>
    <p>Vous trouverez ci-joint votre QR code pour votre e-vignette.</p>
    <p>Merci pour votre achat!</p>
</body>
</html>

