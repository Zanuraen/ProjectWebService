@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: center; align-items: center; min-height: 80vh; padding: 1rem;">
    <div class="glass" style="padding: 3rem; width: 100%; max-width: 450px; text-align: center;">

        <h2 style="color: var(--primary-color); margin-bottom: .5rem;">
            Daftar Member
        </h2>
        <p style="margin-bottom: 2rem; opacity: 0.8;">
            Buat akun baru
        </p>

        {{-- FORM REGISTER --}}
        <form method="POST" action="{{ route('register.store') }}" novalidate>
            @csrf

            {{-- NAMA --}}
            <div style="margin-bottom: 1rem; text-align: left;">
                <label for="name">Nama</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autocomplete="name"
                    autofocus
                    style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.05);
                           border: 1px solid var(--glass-border); color: white; border-radius: 8px;"
                >
                @error('name')
                    <span style="color:#ff4d4d; font-size: 0.85rem;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- EMAIL --}}
            <div style="margin-bottom: 1rem; text-align: left;">
                <label for="email">Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.05);
                           border: 1px solid var(--glass-border); color: white; border-radius: 8px;"
                >
                @error('email')
                    <span style="color:#ff4d4d; font-size: 0.85rem;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div style="margin-bottom: 1rem; text-align: left;">
                <label for="password">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.05);
                           border: 1px solid var(--glass-border); color: white; border-radius: 8px;"
                >
                @error('password')
                    <span style="color:#ff4d4d; font-size: 0.85rem;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- KONFIRMASI PASSWORD --}}
            <div style="margin-bottom: 2rem; text-align: left;">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.05);
                           border: 1px solid var(--glass-border); color: white; border-radius: 8px;"
                >
            </div>

            {{-- BUTTON --}}
            <button type="submit" class="btn-glass" style="width: 100%;">
                Daftar
            </button>

        </form>
    </div>
</div>
@endsection
