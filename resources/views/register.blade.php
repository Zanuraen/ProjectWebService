@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh; padding: 1rem;">
        <div class="glass" style="padding: 3rem; width: 100%; max-width: 450px; text-align: center;">
            <h2 style="color: var(--primary-color);">Daftar Member</h2>
            <p style="margin-bottom: 2rem; opacity: 0.8;">Buat akun baru.</p>

            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <div style="margin-bottom: 1rem; text-align: left;">
                    <label>Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                    @error('name') <span style="color:#ff4d4d">{{ $message }}</span> @enderror
                </div>
                <div style="margin-bottom: 1rem; text-align: left;">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                    @error('email') <span style="color:#ff4d4d">{{ $message }}</span> @enderror
                </div>
                <div style="margin-bottom: 1rem; text-align: left;">
                    <label>Password</label>
                    <input type="password" name="password" required style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                </div>
                <div style="margin-bottom: 2rem; text-align: left;">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                </div>
                <button type="submit" class="btn-glass" style="width: 100%;">Daftar</button>
            </form>
        </div>
    </div>
@endsection