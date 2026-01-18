@extends('layouts.app')

@section('content')
    <div style="padding: 2rem 1rem;">
        <div class="glass" style="max-width: 800px; margin: 0 auto; overflow: hidden; border-radius: 20px;">
            
            <!-- Header Gambar -->
            <div style="position: relative; height: 400px; overflow: hidden;">
                <img src="{{ asset('images/posts/' . $post->image) }}" 
                     alt="{{ $post->title }}" 
                     style="width: 100%; height: 100%; object-fit: cover;">
                
                <!-- Overlay Judul (Opsional) -->
                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(to top, rgba(0,0,0,0.9), transparent); padding: 2rem;">
                    <span style="background: var(--primary-color); color: #000; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">
                        PROMO & BERITA
                    </span>
                    <h1 style="color: white; margin-top: 10px; font-size: 2.5rem; text-shadow: 0 2px 10px rgba(0,0,0,0.5);">
                        {{ $post->title }}
                    </h1>
                </div>
            </div>

            <!-- Konten Lengkap -->
            <div style="padding: 3rem;">
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; color: #aaa; border-bottom: 1px solid var(--glass-border); padding-bottom: 1rem;">
                    <span><i class="fas fa-user"></i> {{ $post->user->name }}</span>
                    <span><i class="fas fa-calendar"></i> {{ $post->created_at->translatedFormat('d F Y') }}</span>
                </div>

                <div style="font-size: 1.1rem; line-height: 1.8; color: rgba(255,255,255,0.9); white-space: pre-line;">
                    {{ $post->description }}
                </div>

                <!-- Tombol Kembali -->
                <div style="margin-top: 3rem;">
                    <a href="{{ route('posts.index') }}" class="btn-glass" style="background: rgba(255,255,255,0.1); color: white;">
                        <i class="fas fa-arrow-left"></i> Kembali ke Berita
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection