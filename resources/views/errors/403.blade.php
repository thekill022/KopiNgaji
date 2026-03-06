<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | KopiNgaji</title>
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
            max-width: 560px;
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .icon-wrapper {
            width: 120px; height: 120px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 20px 40px -12px rgba(239, 68, 68, 0.25);
            animation: shake 3s ease-in-out infinite;
        }
        @keyframes shake {
            0%, 100% { transform: rotate(0deg); }
            5% { transform: rotate(-5deg); }
            10% { transform: rotate(5deg); }
            15% { transform: rotate(-3deg); }
            20% { transform: rotate(3deg); }
            25%, 100% { transform: rotate(0deg); }
        }
        .icon-wrapper i { font-size: 3rem; color: #dc2626; }
        .error-code {
            font-size: 5rem; font-weight: 800;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text; line-height: 1;
        }
        .error-title { font-size: 1.5rem; font-weight: 700; color: #1e293b; margin: 0.5rem 0; }
        .error-message { color: #64748b; font-size: 1rem; line-height: 1.7; margin: 1rem 0 1.5rem; }
        .info-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #f59e0b;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            text-align: left;
            box-shadow: 0 4px 12px -4px rgba(0,0,0,0.06);
        }
        .info-card .info-title {
            font-weight: 600; font-size: 0.85rem; color: #b45309;
            display: flex; align-items: center; gap: 0.4rem; margin-bottom: 0.4rem;
        }
        .info-card .info-text { font-size: 0.85rem; color: #64748b; line-height: 1.6; }
        .btn-group { display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap; }
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
        .btn-secondary {
            background: white; color: #475569;
            border: 1.5px solid #e2e8f0;
        }
        .btn-secondary:hover { background: #f8fafc; border-color: #cbd5e1; transform: translateY(-2px); }
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
            <i class="fa-solid fa-ban"></i>
        </div>
        <div class="error-code">403</div>
        <h1 class="error-title">Akses Ditolak</h1>
        <p class="error-message">
            {{ $exception->getMessage() ?: 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.' }}
        </p>

        <div class="info-card">
            <div class="info-title">
                <i class="fa-solid fa-circle-info"></i> Mengapa ini terjadi?
            </div>
            <div class="info-text">
                Halaman ini mungkin memerlukan peran atau izin khusus. 
                Jika Anda pemilik UMKM, pastikan UMKM Anda sudah diverifikasi oleh admin. 
                Hubungi admin jika Anda merasa ini adalah kesalahan.
            </div>
        </div>

        <div class="btn-group">
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            @auth
                @if(Auth::user()->role === 'OWNER')
                    <a href="{{ route('seller.dashboard') }}" class="btn btn-primary">
                        <i class="fa-solid fa-house"></i> Dashboard Seller
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="fa-solid fa-house"></i> Beranda
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk
                </a>
            @endauth
        </div>
    </div>
</body>
</html>
