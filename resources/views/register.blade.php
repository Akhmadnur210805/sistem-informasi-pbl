<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | SIMPATIK BAZNAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        html, body { 
            min-height: 100vh; 
            margin: 0; 
        }
        
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            background-image: url("{{ asset('images/baznas11.jpeg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
            padding: 40px 15px;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.55); 
            z-index: 0;
        }

        .register-box {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-top: 6px solid #1e5128; 
        }

        .logo-container {
            width: 100px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-container img { 
            width: 100%; 
            height: auto;
        }

        .register-title {
            color: #1e5128;
            font-weight: 700;
            text-align: center;
            margin-bottom: 5px;
        }

        .register-subtitle {
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

        .btn-register {
            background-color: #1e5128;
            color: #ffffff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 12px;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-register:hover {
            background-color: #2d7a3c;
            color: #fff;
            transform: translateY(-2px);
        }

        .login-link {
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
    <div class="register-box shadow-lg">
        <div class="logo-container">
            <img src="{{ asset('images/baznas12.png') }}" alt="Logo BAZNAS">
        </div>
        
        <h3 class="register-title">DAFTAR AKUN</h3>
        <p class="register-subtitle">Sistem Informasi Pengajuan Bantuan Zakat</p>

        @if ($errors->any())
            <div class="alert alert-danger p-2 small mb-3">
                <ul class="mb-0 ps-2" style="list-style: none;">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama sesuai KTP" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label small">Alamat Email</label>
                <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label small">Kata Sandi</label>
                <div class="password-container">
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                    <span class="password-toggle" id="togglePassword">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-register w-100 mb-3 shadow-sm">DAFTAR SEKARANG</button>
        </form>

        <div class="text-center small">
            <span class="text-muted">Sudah punya akun?</span> 
            <a href="{{ route('login') }}" class="login-link">Masuk di sini</a>
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