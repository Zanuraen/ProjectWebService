@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: center; align-items: center; min-height: 80vh; padding: 1rem;">
        <div class="glass" style="padding: 3rem; width: 100%; max-width: 400px; text-align: center;">
            <h2 style="color: var(--primary-color);">Login Member</h2>
            <p style="margin-bottom: 2rem; opacity: 0.8;">Silakan masuk.</p>

            <form method="POST" action="{{ route('login.process') }}"> <!-- PERHATIKAN ROUTE INI -->
                @csrf
                <div style="margin-bottom: 1.5rem; text-align: left;">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                    @error('email') <span style="color:#ff4d4d">{{ $message }}</span> @enderror
                </div>
                <div style="margin-bottom: 2rem; text-align: left;">
                    <label>Password</label>
                    <input type="password" name="password" required style="width: 100%; padding: 0.8rem; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: white; border-radius: 8px;">
                    @error('password') <span style="color:#ff4d4d">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn-glass" style="width: 100%;">Masuk</button>
            </form>
        </div>
    </div>
@endsection