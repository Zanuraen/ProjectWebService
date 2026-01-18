@extends('layouts.app')

@section('content')
    <div style="padding: 2rem 1rem;">
        
        <!-- Bagian Profil -->
        <div class="glass" style="max-width: 800px; margin: 0 auto 3rem auto; padding: 2rem; display: flex; align-items: center; gap: 2rem; border: 1px solid var(--primary-color);">
            <div style="width: 100px; height: 100px; background: #2c3e50; border-radius: 50%; border: 3px solid var(--primary-color); display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                <i class="fas fa-user"></i>
            </div>
            <div>
                <h2>Halo, {{ Auth::user()->name }}</h2>
                <p style="color: var(--primary-color);">Status: Active Member</p>
                <p style="font-size: 0.9rem; color: #aaa;">Email: {{ Auth::user()->email }}</p>
            </div>
        </div>

        <!-- Judul Paket -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-size: 2rem; margin-bottom: 0.5rem;">Pilih Paket Keanggotaan</h2>
            <p style="color: rgba(255,255,255,0.7);">Dikelola oleh Admin Gymnastic.</p>
        </div>

        <!-- GRID PAKET (Dinamis) -->
        @if($packages->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; max-width: 1400px; margin: 0 auto 4rem auto;">
                
                @foreach($packages as $package)
                    <!-- Logika Style jika Paket Featured -->
                    @if($package->is_featured)
                        <div class="glass" style="padding: 2rem; display: flex; flex-direction: column; border: 2px solid var(--primary-color); box-shadow: 0 0 20px rgba(0, 242, 254, 0.3); transform: scale(1.05); position: relative;">
                            <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: var(--primary-color); color: #000; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">REKOMENDASI</div>
                    @else
                        <div class="glass" style="padding: 2rem; display: flex; flex-direction: column; border: 1px solid rgba(255,255,255,0.2);">
                    @endif
                    
                        <h3 style="font-size: 1.5rem; color: {{ $package->is_featured ? 'var(--primary-color)' : '#ccc' }}; margin-bottom: 0.5rem;">{{ $package->name }}</h3>
                        <div style="font-size: 1.2rem; color: #aaa; margin-bottom: 1rem;">{{ $package->type }}</div>
                        
                        <div style="font-size: 2.5rem; font-weight: 700; color: white; margin-bottom: 1.5rem;">
                            Rp {{ number_format($package->price, 0, ',', '.') }}
                        </div>
                        
                        <!-- Menampilkan Fitur (dianggap text dengan pemisah baris atau koma) -->
                        <div style="background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 8px; margin-bottom: 2rem; flex-grow: 1; white-space: pre-line; color: #ddd;">
                            {{ $package->features }}
                        </div>

                        <!-- Tombol Pesan -->
                        <button onclick="alert('Fitur pembayaran akan segera hadir!')" class="btn-glass" style="width: 100%; {{ $package->is_featured ? 'background: var(--primary-color); color: #1a1a2e; font-weight: bold;' : '' }}">
                            {{ $package->is_featured ? 'Ambil Sekarang' : 'Pilih Paket' }}
                        </button>
                    </div>
                @endforeach

            </div>
        @else
            <div style="text-align: center; padding: 2rem;">
                <p>Belum ada paket yang tersedia saat ini. Hubungi Admin.</p>
            </div>
        @endif


        <!-- Riwayat Reservasi (Dinamis + KODE UNIK) -->
        <div class="glass" style="max-width: 1000px; margin: 0 auto; padding: 2rem;">
            <h3 style="margin-bottom: 1.5rem; color: var(--primary-color); border-bottom: 1px solid var(--glass-border); padding-bottom: 10px;">Riwayat Reservasi Saya</h3>
            
            @if($bookings->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left; color: white;">
                        <tr style="border-bottom: 1px solid var(--glass-border); color: var(--primary-color);">
                            <th style="padding: 1rem;">Kelas</th>
                            <th style="padding: 1rem;">Tanggal</th>
                            <th style="padding: 1rem;">Waktu</th>
                            <th style="padding: 1rem;">Catatan</th>
                            <th style="padding: 1rem;">Status & Kode</th>
                        </tr>
                        
                        @foreach($bookings as $b)
                        <tr>
                            <td style="padding: 1rem; font-weight: 600;">{{ $b->class_name }}</td>
                            <td style="padding: 1rem;">{{ \Carbon\Carbon::parse($b->date)->translatedFormat('d F Y') }}</td>
                            <td style="padding: 1rem;">{{ $b->time }}</td>
                            <td style="padding: 1rem; color: #aaa; font-size: 0.9rem;">{{ $b->notes ?? '-' }}</td>
                            
                            <td style="padding: 1rem;">
                                @switch($b->status)
                                    @case('approved')
                                        <!-- Jika Approved, Tampilkan Status DAN KODE UNIK -->
                                        <div style="display: flex; flex-direction: column; gap: 5px;">
                                            <span style="background: rgba(0,255,136,0.2); color: #00ff88; padding: 5px 10px; border-radius: 5px; font-size: 0.8rem; border: 1px solid #00ff88;">
                                                <i class="fas fa-check"></i> Disetujui
                                            </span>
                                            
                                            <!-- TAMPILAN KODE UNTUK KASIR -->
                                            <div style="background: rgba(0, 242, 254, 0.3); color: var(--primary-color); padding: 5px 10px; border-radius: 5px; font-weight: bold; font-size: 1rem; border: 1px solid var(--primary-color); text-align: center; letter-spacing: 1px; margin-top: 5px;">
                                                {{ $b->reservation_code }}
                                            </div>
                                            <small style="color: #aaa; font-size: 0.7rem; text-align: center;">Tunjukkan kode ini ke kasir</small>
                                        </div>
                                    @break

                                    @case('rejected')
                                        <span style="background: rgba(255, 77, 77, 0.2); color: #ff4d4d; padding: 5px 10px; border-radius: 5px; font-size: 0.8rem; border: 1px solid #ff4d4d;">
                                            <i class="fas fa-times"></i> Ditolak
                                        </span>
                                    @break

                                    @default
                                        <span style="background: rgba(241, 196, 15, 0.2); color: #f1c40f; padding: 5px 10px; border-radius: 5px; font-size: 0.8rem; border: 1px solid #f1c40f;">
                                            <i class="fas fa-clock"></i> Menunggu
                                        </span>
                                @endswitch
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            @else
                <p style="text-align: center; color: #aaa; padding: 2rem;">Anda belum memiliki riwayat reservasi.</p>
            @endif
        </div>

    </div>
@endsection