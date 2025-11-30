<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lawyer Case Diary</title>

    <!-- App CSS -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .sidebar {
            min-height: 100vh;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 1000;
            }
        }

        #sidebarCollapse .list-group-item {
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }
        #sidebarCollapse .list-group-item:hover {
            background-color: #0d6efd;
            color: #fff;
        }
        #sidebarCollapse .list-group-item.active {
            font-weight: 500;
        }
    </style>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

    @stack('styles')
</head>

<body>
    <div class="d-flex" id="wrapper">
    
        
  

        @include('layouts.sidebar')

        <div id="page-content-wrapper" class="flex-grow-1">
            @include('layouts.navbar')

            <div class="container-fluid mt-3">

                
                @yield('content')
            </div>
        </div>
    </div>

    <!-- jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <!-- PDF Export (pdfmake) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <!-- DataTables Search Highlight -->
    <script src="https://cdn.datatables.net/plug-ins/1.13.6/features/searchHighlight/dataTables.searchHighlight.min.js"></script>
    <script src="https://bartaz.github.io/sandbox.js/jquery.highlight.js"></script>

    <!-- App JS -->
    <script src="{{ asset('assets/js/app.js') }}"></script>





 





    @stack('scripts')
</body>
</html>
