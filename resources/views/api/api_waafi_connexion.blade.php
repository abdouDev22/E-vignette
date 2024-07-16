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
  <h1>Welcome to Waafi</h1>
 <div class="form-container">
    <form id="addForm" method="post" action="{{ route('page_achat',['id' => $voiture,'id_vignette'=> $vignette,'id_mode'=>$id_mode]) }}">
      @csrf
      <div class="form-group">
        <label for="phone">Téléphone:</label>
        <input type="tel" id="phone" name="phone" required>
      </div>
      <div class="form-group">
        <label for="password">Mot de Passe:</label>
        <input type="password" id="password"  name="password" required>
      </div>
      <button type="submit">valider</button>
    </form>
  </div>
</body>
</html>