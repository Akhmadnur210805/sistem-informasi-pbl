<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SIMPATIK BAZNAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        /* Perbaikan utama: min-height 100vh agar background tidak terputus */
        html, body { 
            min-height: 100vh; 
            margin: 0; 
        }
        
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            
            /* BACKGROUND SETTINGS */
            background-image: url("{{ asset('images/baznas11.jpeg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed; /* Mengunci background agar tidak ikut scroll */
            position: relative;
            padding: 40px 15px; /* Memberi ruang atas bawah saat di-scroll */
        }

        /* Overlay Gelap Fixed agar menutupi seluruh halaman saat di-scroll */
        body::before {
            content: "";
            position: fixed; /* Fixed agar overlay tidak habis saat di-scroll */
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.55); 
            z-index: 0;
        }

        .login-box {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background: #ffffff; /* Putih Solid (Clean) */
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-top: 6px solid #1e5128; 
        }

        /* ========================================= */
        /* CSS KHUSUS TOMBOL KEMBALI */
        /* ========================================= */
        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #6c757d;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .btn-back i {
            margin-right: 5px;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .btn-back:hover {
            color: #1e5128;
        }

        .btn-back:hover i {
            transform: translateX(-4px);
        }
        /* ========================================= */

        .logo-container {
            width: 100px;
            margin: 10px auto 20px; /* Ditambah margin top sedikit agar tidak menabrak tombol kembali */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-container img { 
            width: 100%; 
            height: auto;
        }

        .login-title {
            color: #1e5128;
            font-weight: 700;
            text-align: center;
            margin-bottom: 5px;
        }

        .login-subtitle {
            color: #666;
            font-size: 0.85rem;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-label {
            color: #333;
            font-weight: 500;
        }

        .form-control {
            background: #f8f9fa;
            border: 1px solid #ddd;
            color: #333;
            border-radius: 8px;
            padding: 12px;
        }

        .form-control:focus {
            background: #fff;
            border-color: #1e5128;
            box-shadow: 0 0 0 0.2rem rgba(30, 81, 40, 0.1);
            color: #333;
        }

        .btn-login {
            background-color: #1e5128;
            color: #ffffff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 12px;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-login:hover {
            background-color: #2d7a3c;
            color: #fff;
            transform: translateY(-2px);
        }

        .divider {
            display: flex; align-items: center; text-align: center;
            color: #888; margin: 1.5rem 0;
            font-size: 0.8rem;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; border-bottom: 1px solid #eee;
        }
        .divider:not(:empty)::before { margin-right: .5em; }
        .divider:not(:empty)::after { margin-left: .5em; }

        .btn-google {
            background-color: #fff; 
            color: #444; 
            font-weight: 500;
            border: 1px solid #ddd;
            border-radius: 8px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 10px; 
            text-decoration: none;
            transition: 0.2s;
        }
        
        .btn-google:hover { background-color: #f8f9fa; }

        .register-link {
            color: #1e5128;
            font-weight: 600;
            text-decoration: none;
        }

        .password-container { position: relative; }
        .password-toggle {
            position: absolute; right: 15px; top: 50%;
            transform: translateY(-50%); cursor: pointer; color: #888;
        }
    </style>
</head>
<body>
    <div class="login-box shadow-lg">
        
        <a href="{{ route('landing') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <div class="logo-container">
            <img src="{{ asset('images/baznas12.png') }}" alt="Logo BAZNAS">
        </div>
        
        <h3 class="login-title">SIMPATIK</h3>
        <p class="login-subtitle">Badan Amil Zakat Nasional</p>

        @if(session('success'))
            <div class="alert alert-success p-2 small text-center mb-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any() || session('error'))
            <div class="alert alert-danger p-2 small mb-3">
                <ul class="mb-0 ps-2" style="list-style: none;">
                    @if(session('error')) <li>{{ session('error') }}</li> @endif
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.manual') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small">Alamat Email</label>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
            </div>

            <div class="mb-4">
                <label class="form-label small">Kata Sandi</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                    <span class="password-toggle" id="togglePassword">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-2 shadow-sm">MASUK</button>
        </form>

        <div class="divider">atau</div>

        <a href="{{ route('google.login') }}" class="btn btn-google w-100 mb-4 shadow-sm">
            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="G" style="width:16px; margin-right:10px;">
            Masuk dengan Google
        </a>

        <div class="text-center small">
            <span class="text-muted">Belum punya akun?</span> 
            <a href="{{ route('register') }}" class="register-link">Daftar Sekarang</a>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');
        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>