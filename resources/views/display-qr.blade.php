<!-- resources/views/display-qr.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Code QR Généré</title>
</head>
<body>
    <h1>Voici votre Code QR</h1>
    <img src="{{ $qrCodeUrl }}" alt="Code QR">
</body>
</html>
