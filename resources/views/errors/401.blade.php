<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>401 - Tidak Terautentikasi | KopiNgaji</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
            color: #334155;
            overflow: hidden;
        }
        .container {
            text-align: center;
            padding: 2rem;
            max-width: 520px;
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .icon-wrapper {
            width: 120px; height: 120px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px -12px rgba(251, 191, 36, 0.3);
            animation: pulse 2.5s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .icon-wrapper i { font-size: 3rem; color: #b45309; }
        .error-code {
            font-size: 5rem; font-weight: 800;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text; line-height: 1;
        }
        .error-title { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0.5rem 0; }
        .error-message { color: #64748b; font-size: 1rem; line-height: 1.7; margin: 1rem 0 2rem; }
        .btn {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.75rem 1.75rem; border-radius: 12px; font-weight: 600;
            text-decoration: none; font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: white; box-shadow: 0 8px 24px -6px rgba(79, 70, 229, 0.4);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 28px -6px rgba(79, 70, 229, 0.5); }
        .logo { display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-bottom: 2rem; }
        .logo i { font-size: 1.5rem; color: #4f46e5; }
        .logo span { font-weight: 700; font-size: 1.25rem; color: #1e293b; }
        .logo .accent { color: #4f46e5; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <i class="fa-solid fa-mug-hot"></i>
            <span>Kopi<span class="accent">Ngaji</span></span>
        </div>
        <div class="icon-wrapper">
            <i class="fa-solid fa-lock"></i>
        </div>
        <div class="error-code">401</div>
        <h1 class="error-title">Tidak Terautentikasi</h1>
        <p class="error-message">
            Anda perlu masuk terlebih dahulu untuk mengakses halaman ini. 
            Silakan login dengan akun Anda untuk melanjutkan.
        </p>
        <a href="{{ route('login') }}" class="btn btn-primary">
            <i class="fa-solid fa-right-to-bracket"></i> Masuk ke Akun
        </a>
    </div>
</body>
</html>
