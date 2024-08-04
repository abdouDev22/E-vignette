<!DOCTYPE html>
<html>
<head>
    <title>Code de Vérification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #4CAF50;
        }
        p {
            font-size: 18px;
            margin: 10px 0;
        }
        strong {
            font-size: 20px;
            color: #E91E63;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Votre Code de Vérification</h1>
        <p>Votre code de vérification est : <strong>{{ $verificationCode }}</strong></p>
        <p>Merci de l'entrer sur la page de vérification pour compléter votre inscription.</p>
    </div>
</body>
</html>

