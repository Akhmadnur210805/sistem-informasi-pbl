<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi PBL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            background-color: #667eea;
            background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .login-box {
            width: 100%;
            max-width: 420px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
        }
        .login-box .logo {
            display: block;
            margin: 0 auto 20px;
            width: 80px;
            height: 80px;
        }
        .login-box h5, .login-box .form-label, .login-box .alert ul li {
            color: #ffffff !important;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: #fff;
            border-radius: 8px;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.3);
            border-color: #fff;
            color: #fff;
            box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .btn-login {
            background-color: #fff;
            border: none;
            color: #6a11cb;
            font-weight: 600;
            padding: 10px 0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #f1f1f1;
            transform: translateY(-2px);
        }
        .password-container { position: relative; }
        .password-toggle-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255, 255, 255, 0.8);
        }
        .divider {
            display: flex; align-items: center; text-align: center;
            color: rgba(255,255,255,0.8); margin: 1.5rem 0;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; border-bottom: 1px solid rgba(255,255,255,0.4);
        }
        .divider:not(:empty)::before { margin-right: .5em; }
        .divider:not(:empty)::after { margin-left: .5em; }
        .btn-google {
            background-color: #fff; color: #444; font-weight: 500;
            border-radius: 8px; transition: all 0.3s ease;
            display: flex; align-items: center; justify-content: center;
        }
        .btn-google:hover {
            background-color: #f1f1f1; transform: translateY(-2px);
        }
        .btn-google img { width: 20px; height: 20px; margin-right: 10px; }
    </style>
</head>
<body>
    <div class="login-box">
        <img src="{{ asset('images/poliatala.png') }}" alt="Logo Politeknik Negeri Tanah Laut" class="logo">
        <h5 class="text-center fw-light mb-4">Sistem Informasi PBL</h5>

        @if ($errors->any())
            <div class="alert alert-danger p-2" style="background: rgba(255,0,0,0.2); border-color: rgba(255,255,255,0.5);">
                <ul class="mb-0 small ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            {{-- PASTIKAN BARIS INI ADA --}}
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control" placeholder="contoh@mhs.politala.ac.id" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3 password-container">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan kata sandi" required>
                <span class="password-toggle-icon" id="togglePassword">
                    <i class="bi bi-eye-slash"></i>
                </span>
            </div>
            <button type="submit" class="btn btn-login w-100 mt-3">Masuk</button>
        </form>

        <div class="divider">atau</div>

        <a href="{{ route('google.login') }}" class="btn btn-google w-100">
            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google logo">
            Masuk dengan Google
        </a>
    </div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const icon = togglePassword.querySelector('i');

    togglePassword.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });
</script>
</body>
</html>
