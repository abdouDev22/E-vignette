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
            <h5 class="user-name">{{ session('username') ?? 'Guest' }}</h5>

        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('welcome') }}"><i class="fas fa-home"></i> Home</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" href="{{ route('achatVignette') }}"><i class="fas fa-shopping-bag"></i> Shop</a>
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

   <</div>
<!-- Main content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Choisir le Mode de Paiement</h1>
    </div>

    <!-- Payment Options -->
    <div class="row justify-content-center mt-5">
        @foreach ($mode_paiements as $mode_paiement)
            <div class="col-md-5 mb-4">
                <div class="card payment-option animate__animated animate__fadeInLeft">
                    <div class="card-body text-center p-5">
                        @if ($mode_paiement->mode == 'D-money')
                            <img src="{{ asset('img/dmoney.png') }}" alt="D-money" class="payment-icon animate__animated animate__pulse animate__infinite">
                            <h2 class="payment-title mb-4">D-money</h2>
                            <p class="payment-text mb-4">Paiement rapide et sécurisé avec D-money</p>
                            <a href="#" class="btn btn-light btn-lg" id="dmoney">Choisir {{ $mode_paiement->mode }}</a>
                        @else
                            <img src="{{ asset('img/waafi.png') }}" alt="Waafi" class="payment-icon animate__animated animate__pulse animate__infinite">
                            <h2 class="payment-title mb-4">{{ $mode_paiement->mode }}</h2>
                            <p class="payment-text mb-4">Paiement facile et instantané via {{ $mode_paiement->mode }}</p>
                            <a href="{{ route('codeqr', ['voiture' => $voiture, 'vignette' => $vignette, 'modePaiement' => $mode_paiement->id]) }}" class="btn btn-light btn-lg">Choisir {{ $mode_paiement->mode }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

                <!-- Information -->
                <div class="row mt-5">
                    <div class="col-md-8 mx-auto text-center">
                        <h3 class="mb-4">Pourquoi choisir nos méthodes de paiement ?</h3>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-lock fa-3x mb-3 text-primary"></i>
                                <h5>Sécurité Maximale</h5>
                                <p>Vos transactions sont protégées par les dernières technologies de cryptage</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-bolt fa-3x mb-3 text-primary"></i>
                                <h5>Rapidité</h5>
                                <p>Paiement instantané et confirmation immédiate de votre transaction</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-hand-holding-usd fa-3x mb-3 text-primary"></i>
                                <h5>Facilité d'utilisation</h5>
                                <p>Interface intuitive pour une expérience de paiement sans tracas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Back Button -->
    <a href="{{ route('vignette', ['voiture' => $voiture->id]) }}" class="btn btn-primary btn-lg abou-back animate__animated animate__fadeInUp">
        <i class="fas fa-arrow-left me-2"></i> Retour au Dashboard
    </a>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const logoutBtn = document.getElementById('logoutBtn');

        const dmoney=document.querySelector('#dmoney');
        dmoney.addEventListener('click', (e) => {
            e.preventDefault();
            alert("D-money n'est pas encore disponible");
        });

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
            content.classList.toggle('full-width');
        });

        logoutBtn.addEventListener('click', () => {
            alert('Logging out... Goodbye!');
            // Here you would typically handle the logout process
            // For example, redirecting to a logout page or clearing session data
        });

        // Initialize DataTable with search animation and custom styling
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "pageLength": 5,
                "lengthChange": false,
                "info": false,
                "dom": '<"top"f>rt<"bottom"p><"clear">',
                "language": {
                    "search": "_INPUT_",
                    "searchPlaceholder": "Search products..."
                },
                "initComplete": function () {
                    var api = this.api();
                    api.$('td').click(function () {
                        api.search(this.innerHTML).draw();
                    });
                    $('.dataTables_filter input')
                        .off('.DT')
                        .on('input.DT', function () {
                            api.search(this.value).draw();
                        })
                        .wrap('<div class="animate__animated animate__fadeIn"></div>');
                },
                "drawCallback": function () {
                    $('tbody tr').addClass('animate__animated animate__fadeIn');
                }
            });
        });

        // Add animation classes to elements as they come into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated', 'animate__fadeIn');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.card').forEach(card => {
            observer.observe(card);
        });
        
    </script>
</body>

</html>

