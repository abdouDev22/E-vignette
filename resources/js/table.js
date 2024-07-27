
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
    