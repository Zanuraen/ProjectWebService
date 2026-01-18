<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gymnastic - Liquid Glass</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --glass-bg: rgba(255, 255, 255, 0.1); --glass-border: rgba(255, 255, 255, 0.2); --primary-color: #00f2fe; --secondary-color: #4facfe; --text-color: #ffffff; --bg-gradient: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: var(--bg-gradient); color: var(--text-color); min-height: 100vh; overflow-x: hidden; position: relative; }
        .blob { position: absolute; border-radius: 50%; filter: blur(80px); z-index: -1; opacity: 0.6; animation: float 10s infinite ease-in-out alternate; }
        .blob-1 { top: -10%; left: -10%; width: 500px; height: 500px; background: #ff00cc; animation-delay: 0s; }
        .blob-2 { bottom: -10%; right: -10%; width: 600px; height: 600px; background: #3333ff; animation-delay: -5s; }
        .blob-3 { top: 40%; left: 40%; width: 300px; height: 300px; background: #00f2fe; animation-duration: 15s; }
        @keyframes float { 0% { transform: translate(0, 0) scale(1); } 100% { transform: translate(30px, 50px) scale(1.1); } }
        .glass { background: var(--glass-bg); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid var(--glass-border); border-radius: 16px; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); }
        nav { position: fixed; top: 0; width: 100%; padding: 1rem 5%; display: flex; justify-content: space-between; align-items: center; z-index: 1000; background: rgba(26, 26, 46, 0.8); backdrop-filter: blur(20px); border-bottom:1px solid var(--glass-border); }
        .logo { font-size: 1.5rem; font-weight: 700; color: white; text-decoration: none; }
        .logo span { color: var(--primary-color); }
        .nav-links { display: flex; gap: 2rem; list-style: none; align-items: center; }
        .nav-links a { text-decoration: none; color: var(--text-color); font-weight: 500; transition: 0.3s; font-size: 0.95rem; }
        .nav-links a:hover { color: var(--primary-color); }
        .btn-glass { padding: 0.6rem 1.5rem; border: none; outline: none; background: rgba(255, 255, 255, 0.1); color: white; border: 1px solid var(--primary-color); border-radius: 50px; cursor: pointer; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; font-size: 0.9rem; }
        .btn-glass:hover { background: var(--primary-color); color: #1a1a2e; box-shadow: 0 0 15px var(--primary-color); }
        main { padding-top: 80px; min-height: 100vh; }
        .toast { position: fixed; bottom: 30px; right: 30px; padding: 1rem 2rem; background: rgba(0, 242, 254, 0.2); backdrop-filter: blur(15px); border-left: 5px solid var(--primary-color); color: white; border-radius: 4px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index: 2000; }
        .toast-error { border-left-color: #ff4d4d; background: rgba(255, 77, 77, 0.2); }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>

    <nav>
        <a href="{{ route('home') }}" class="logo">GYMNAS<span>TIC</span></a>
        <ul class="nav-links">
            <li><a href="{{ route('home') }}">Beranda</a></li>
            
            @guest
                <!-- Menu jika Belum Login -->
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}" class="btn-glass">Daftar</a></li>
            @else
                <!-- Menu jika Sudah Login -->
                <li><a href="{{ route('booking') }}">Booking</a></li>
                <li><a href="{{ route('member') }}">Member</a></li>
                <li><a href="{{ route('posts.index') }}" style="color: var(--primary-color);">Berita & Promo</a></li>
                
                <!-- Menu Hanya untuk ADMIN -->
                @if(Auth::user()->is_admin)
                    <li>
                        <a href="{{ route('admin.dashboard') }}" style="background: rgba(0, 242, 254, 0.2); padding: 5px 12px; border-radius: 8px; border: 1px solid var(--primary-color); color: white; font-size: 0.9rem;">
                            <i class="fas fa-user-shield"></i> Admin Panel
                        </a>
                    </li>
                @endif
                
                <!-- Logout -->
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none; border:none; color:white; cursor:pointer; font-weight:500; font-family:inherit; font-size:0.95rem;">Logout</button>
                    </form>
                </li>
            @endguest
        </ul>
    </nav>

    <main>
        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="toast show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Notifikasi Error (Misal akses admin ditolak) -->
        @if(session('error'))
            <div class="toast toast-error show">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>