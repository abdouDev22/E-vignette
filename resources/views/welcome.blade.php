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
                <a class="nav-link" href="{{ route('welcome') }}"><i class="fas fa-home"></i>Acceuill</a>
            </li>
           
            <li class="nav-item">
                <a class="nav-link" href="{{ route('achatVignette') }}"><i class="fas fa-shopping-bag"></i> Achat</a>
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

    <main id="content" class="content">
    <div class="container">
        <h1 class="mb-4 animate__animated animate__fadeInDown">Welcome, {{ session('username', 'Guest') }}!</h1>
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="card shadow-sm animate__animated animate__fadeInUp">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Historique des transactions des voitures</h5>
                        <table id="dataTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>matricule</th>
                                    <th>marque</th>
                                    <th>chevaux</th>
                                    <th>type</th>
                                   
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($voitures as $voiture)
                                <tr>
                                    <td>{{$voiture->matricule}}</td>
                                    <td>{{$voiture->marque}}</td>
                                    <td>{{$voiture->chevaux}}</td>
                                    <td>{{$voiture->type}}</td>
                                    
                                    <td>
                                      
        <a href="{{ route('vignetteObtenue', ['voiture' => $voiture->id]) }}" class="btn btn-sm btn-primary">
           Détails des transactions
        </a>
       
    
                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


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

