<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  @vite(['resources/scss/api_waafi_c.scss','resources/js/app.js'])
</head>
<body>
  <a href="{{ route('service', ['voiture' => $voiture->id, 'vignette' => $vignette->id]) }}" class="home">retour</a>
  <h1>Welcome to Waafi</h1>
 <div class="form-container">
 
    <form id="addForm" method="post" action="{{ route('page_achat', ['voiture' => $voiture, 'vignette' => $vignette, 'modePaiement' => $modePaiement]) }}">
      @csrf
      <div class="form-group">
        <label for="phone">Téléphone:</label>
        <input type="number" id="phone" name="phone" required>
      </div>
      <div class="form-group">
        <label for="password">Mot de Passe:</label>
        <input type="password" id="password"  name="password" required>
      </div>
      @if(isset($error))
    <div class="alert alert-danger">
        {{ $error }}
    </div>
@endif

      <button type="submit">valider</button>
    </form>
  </div>
</body>
</html>