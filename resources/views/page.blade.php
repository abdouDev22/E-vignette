<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  @vite('resources/js/app.js')
  @vite('resources/css/gsap.css')
</head>
<body>

  <div class="container">
      <!-- LOADER -->
      <div class="loader">
          <h1>Projet Tutoré</h1>
          <h2>E-vignette</h2>
      </div>
      <!-- navbar -->
      <nav>
          <div class="logo">
              <span>E-vignette</span>
          </div>
          <div class="menu">
              <ul>
                  <li><a href="/">Home</a></li>
                  <li><a href="/login">Login</a></li>
                  <li><a href="/register">singup</a></li>
              </ul>
          </div>
      </nav>
      <!-- wrapper -->
      <div class="wrapper">
          <!-- content -->
          <div class="content">
              <div class="h1">
                  <h1>Solution</h1>
              </div>
              <div class="h1">
                  <h1>Moderne</h1>
              </div>
              <p>Ce projet remplace les vignettes de voitures en papier par des codes QR pour moderniser 
                  et simplifier le système, réduisant les coûts et améliorant l'accès aux données pour les 
                  autorités.</p>
             
              

          </div>

          <!-- img section -->
          <div class="img">
              <div class="subimg one">
                  <img src="./img/mainm.jpg" alt="">
                  <div class="bg"></div>
              </div>
              <div class="subimg two">
                  <img src="./img/leftm.jpg" alt="">
                  <div class="bg2"></div>

              </div>
              <div class="subimg three">
                  <img src="./img/logo.jpg" alt="">
                  <div class="bg3"></div>

              </div>
          </div>
      </div>
  </div>
 
</body>
</html>