<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Informasi PBL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Link untuk Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: url("{{ asset('images/poo.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            width: 100%;
            max-width: 380px;
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 25px rgba(0,0,0,0.25);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
        }
        .login-box img {
            display: block;
            margin: 0 auto 15px;
            width: 80px;
        }
        .login-box h5,
        .login-box label,
        .login-box .form-label,
        .login-box .alert,
        .login-box ul li {
            color: #fff !important;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255,255,255,0.4);
            color: #fff;
            padding-right: 40px; /* Memberi ruang untuk ikon mata */
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.25);
            border-color: #fff;
            color: #fff;
            box-shadow: none;
        }
        .form-control::placeholder {
            color: rgba(255,255,255,0.8);
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
        }
        /* Style untuk ikon mata */
        .password-container {
            position: relative;
        }
        .password-toggle-icon {
            position: absolute;
            top: 38px;
            right: 10px;
            cursor: pointer;
            z-index: 100;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <img src="{{ asset('images/poliatala.png') }}" alt="Logo">
        <h5 class="text-center mb-4">Masuk ke Sistem Informasi PBL</h5>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="kode_admin" class="form-label">Mahasiswa/Dosen/Admin/Pengelola</label>
                <input type="text" name="kode_admin" class="form-control" placeholder="Masukkan kode" required autofocus>
            </div>
            
            {{-- Bagian Password yang dimodifikasi --}}
            <div class="mb-3 password-container">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required>
                <span class="password-toggle-icon">
                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                </span>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
    </div>

<script>
    const togglePasswordIcon = document.querySelector('#togglePasswordIcon');
    const passwordInput = document.querySelector('#password');

    togglePasswordIcon.parentElement.addEventListener('click', function () {
        // Toggle tipe input
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Ganti ikon mata
        togglePasswordIcon.classList.toggle('bi-eye');
        togglePasswordIcon.classList.toggle('bi-eye-slash');
    });
</script>

</body>
</html>