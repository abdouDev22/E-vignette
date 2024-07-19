<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  @vite(['resources/scss/api_waafi_a.scss','resources/js/app.js'])
</head>

<body>
  <div class="content">
    <h3>Payment successful!</h3>
    <h1>DJF{{ $prix }}</h1>
    <p class="date"> {{ $date }}</p>
    <div class="carreblack">
      <p>Sender name <span>{{ $user_con_name }}</span></p>
      <p>Sender <span>{{ $telephone }}</span> </p>
      <p>Merchant name  <span>E-vignette</span></p>
      <p>Merchant ID <span>12</span></p>
      <p>Total  <span>DJF{{ $prix }}</span></p>
    </div>
  </div>
</body>
</html>