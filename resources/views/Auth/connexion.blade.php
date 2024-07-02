<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="styles.css">
    @vite(['resources/scss/connexion.scss','resources/js/app.js'])
</head>
<body>

  <div class="login-container">
    <h2>Connexion</h2>
    <form action="/login" method="post">
      @csrf
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="input-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit"><span class="connexion"><a></a></span></button>
        <span class="inscription"><a href="#"></a></span>
    </form>
</div>
@if(isset($valid))
        <script>
          alert('Email ou mot de passe incorrect.')
        </script>
        @endif
</body>
</html>
