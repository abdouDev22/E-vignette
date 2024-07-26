<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
   
    <title>Dashboard</title>

    @vite(['resources/scss/sidebare.scss','resources/js/app.js'])
    @vite(['resources/css/formulaire.css','resources/js/form.js'])
    @vite(['resources/js/table.js'])
</head><body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <button id="toggleSidebar" class="btn btn-outline-light me-2 toggle-btn">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand animate__animated animate__fadeIn" href="#">E-vignette</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <div id="sidebar" class="sidebar">
        <div class="user-profile animate__animated animate__fadeIn">
            <img src="{{ asset('img/dmoney.png') }}" alt="User Avatar" class="user-avatar">
            <h5 class="user-name">{{ session('username', 'Guest') }}</h5>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('welcome') }}"><i class="fas fa-home"></i>Acceuil</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" href="{{ route('achatVignette') }}"><i class="fas fa-shopping-bag"></i> Acheter</a>
            </li>
        </ul>
       
        <div class="mt-auto">
        <a href="{{ route('logout') }}" class="btn btn-light logout-link mx-3" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    </div>
    {{ $slot }}
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
</body>

</html>

