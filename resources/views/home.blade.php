@extends('layouts.app')

@section('content')
<section
    style="
        position: relative;
        z-index: 10;
        text-align: center;
        padding: 6rem 1rem;
    "
>
    <h1 style="font-size: 3.5rem; margin-bottom: 1.5rem;">
        Tubuh Bugar,<br>
        <span style="color: var(--primary-color);">Gaya Hidup Mewah.</span>
    </h1>

    <p style="margin-bottom: 3rem; color: rgba(255,255,255,0.8); max-width: 600px; margin-left: auto; margin-right: auto;">
        Bergabunglah dengan Gymnastic dan rasakan pengalaman fitnes futuristik.
    </p>

    <div style="display: flex; justify-content: center; gap: 1rem;">
        @guest
            <a href="{{ route('register') }}"
               class="btn-glass"
               style="background: var(--primary-color); color: #1a1a2e; font-weight: 700; position: relative; z-index: 20;">
                Mulai Sekarang
            </a>
            <a href="{{ route('login') }}"
               class="btn-glass"
               style="position: relative; z-index: 20;">
                Login
            </a>
        @else
            <a href="{{ route('booking') }}"
               class="btn-glass"
               style="background: var(--primary-color); color: #1a1a2e; font-weight: 700; position: relative; z-index: 20;">
                Booking
            </a>
            <a href="{{ route('member') }}"
               class="btn-glass"
               style="position: relative; z-index: 20;">
                Member
            </a>
        @endguest
    </div>
</section>

<div
    style="
        position: relative;
        z-index: 10;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    "
>
    <div class="glass" style="padding: 2rem; text-align: center;">
        <i class="fas fa-dumbbell" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
        <h3>Alat Modern</h3>
    </div>

    <div class="glass" style="padding: 2rem; text-align: center;">
        <i class="fas fa-users" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
        <h3>Komunitas Solid</h3>
    </div>

    <div class="glass" style="padding: 2rem; text-align: center;">
        <i class="fas fa-swimmer" style="font-size: 3rem; color: var(--primary-color); margin-bottom: 1rem;"></i>
        <h3>Fasilitas Lengkap</h3>
    </div>
</div>
@endsection
