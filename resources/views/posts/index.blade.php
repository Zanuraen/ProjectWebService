@extends('layouts.app')

@section('content')
    <div style="padding: 2rem 1rem;">
        <div style="max-width: 1000px; margin: 0 auto;">
            
            <!-- Header & Pencarian -->
            <div style="text-align: center; margin-bottom:3rem;">
                <h1 style="font-size: 2.5rem; margin-bottom: 1rem;">Berita & Promo Gymnastic</h1>
                
                <!-- Fitur Pencarian -->
                <form action="{{ route('posts.index') }}" method="GET" style="display: inline-block; width: 100%; max-width: 500px;">
                    <div style="position: relative;">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari berita atau promo..." 
                               style="width: 100%; padding: 1rem 2rem; border-radius: 50px; border: none; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid var(--glass-border); color: white; outline: none;">
                        <button type="submit" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--primary-color); cursor: pointer;">
                            <i class="fas fa-search fa-lg"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- List Postingan (Grid & Klik Aja) -->
            @if($posts->count() > 0)
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                    @foreach($posts as $post)
                        <!-- BUNGKUS DENGAN LINK AGAR BISA DIKLIK -->
                        <a href="{{ route('posts.show', $post->id) }}" 
                           style="text-decoration: none; color: inherit; display: block;">
                            
                            <div class="glass" style="padding: 0; overflow: hidden; border-radius: 16px; transition: transform 0.3s; height: 100%; display: flex; flex-direction: column;">
                                
                                <!-- Gambar -->
                                <div style="height: 200px; overflow: hidden; flex-shrink: 0;">
                                    <img src="{{ asset('images/posts/' . $post->image) }}" 
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                
                                <!-- Konten -->
                                <div style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
                                    <h3 style="font-size: 1.3rem; margin-bottom: 0.5rem; color: var(--primary-color);">{{ $post->title }}</h3>
                                    <p style="font-size: 0.9rem; color: #aaa; margin-bottom: 1rem;">Oleh: {{ $post->user->name }}</p>
                                    <p style="color: rgba(255,255,255,0.8); line-height: 1.6; margin-bottom: 1rem;">{{ Str::limit($post->description, 100) }}</p>
                                    
                                    <!-- Teks "Baca Selengkapnya" -->
                                    <div style="margin-top: auto; color: var(--primary-color); font-weight: bold; font-size: 0.9rem;">
                                        Baca Selengkapnya &rarr;
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination (Perhalaman) -->
                <div style="margin-top: 3rem; display: flex; justify-content: center; gap: 10px;">
                    {{ $posts->appends(['search' => request('search')])->links() }}
                </div>

            @else
                <div class="glass" style="text-align: center; padding: 3rem;">
                    <h3 style="margin-bottom: 1rem;">Tidak ada postingan ditemukan.</h3>
                    <p style="color: #aaa;">Coba kata kunci lain atau kembali nanti.</p>
                </div>
            @endif

        </div>
    </div>
@endsection