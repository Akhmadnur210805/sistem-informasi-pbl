<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SIMPATIK BAZNAS') }} | Pimpinan</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7f6; /* Warna abu-abu super terang untuk background */
            overflow-x: hidden;
        }

        /* Layout Grid System */
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        /* Konfigurasi Sidebar */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            background: #1e5128; /* Hijau Utama BAZNAS */
            color: #fff;
            transition: all 0.3s;
            min-height: 100vh;
            position: fixed;
            z-index: 1000;
            box-shadow: 4px 0 10px rgba(0,0,0,0.05);
        }

        /* Konten Utama */
        #content {
            width: calc(100% - 260px);
            min-height: 100vh;
            transition: all 0.3s;
            position: absolute;
            top: 0;
            right: 0;
            display: flex;
            flex-direction: column;
        }

        /* Responsif untuk layar HP (Mobile) */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -260px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
                position: relative;
            }
            #content.active {
                width: 100%;
                position: absolute;
                transform: translateX(260px);
            }
        }
    </style>
</head>
<body>

    <div class="wrapper">
        @include('layout_pimpinan._sidebar')

        <div id="content">
            @include('layout_pimpinan._header')

            <div class="p-4 flex-grow-1">
                @yield('content-header')
                @yield('content')
            </div>

            @include('layout_pimpinan._footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            if(sidebarCollapse){
                sidebarCollapse.addEventListener('click', function () {
                    document.getElementById('sidebar').classList.toggle('active');
                    document.getElementById('content').classList.toggle('active');
                });
            }
        });
    </script>
</body>
</html>