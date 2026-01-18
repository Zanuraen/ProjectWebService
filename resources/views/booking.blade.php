@extends('layouts.app')

@section('content')
    <div style="display: flex; justify-content: center; padding: 4rem 1rem;">
        <div class="glass" style="width: 100%; max-width: 1000px; padding: 3rem;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: 2.5rem; color: var(--primary-color); margin-bottom: 0.5rem;">Reservasi Kelas</h2>
                <p style="color: rgba(255,255,255,0.7);">Pilih jenis olahraga dan jadwal yang Anda inginkan.</p>
            </div>
            
            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem;">
                    
                    <!-- KOLOM KIRI: Pilihan Jenis Olahraga -->
                    <div>
                        <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem; border-bottom: 2px solid var(--primary-color); display: inline-block; padding-bottom: 5px;">1. Pilih Olahraga</h3>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            
                            <!-- Yoga -->
                            <label class="sport-card" style="display: block; padding: 1.5rem; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; cursor: pointer; transition: 0.3s; text-align: center;">
                                <input type="radio" name="class_name" value="Yoga" class="hidden-radio" checked onchange="updateSelection(this)">
                                <i class="fas fa-spa" style="font-size: 2rem; color: var(--primary-color); margin-bottom: 10px;"></i>
                                <div style="font-weight: 600;">Yoga</div>
                            </label>

                            <!-- Cardio -->
                            <label class="sport-card" style="display: block; padding: 1.5rem; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; cursor: pointer; transition: 0.3s; text-align: center;">
                                <input type="radio" name="class_name" value="Cardio" class="hidden-radio" onchange="updateSelection(this)">
                                <i class="fas fa-heartbeat" style="font-size: 2rem; color: #ff4d4d; margin-bottom: 10px;"></i>
                                <div style="font-weight: 600;">Cardio</div>
                            </label>

                            <!-- Lifting -->
                            <label class="sport-card" style="display: block; padding: 1.5rem; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; cursor: pointer; transition: 0.3s; text-align: center;">
                                <input type="radio" name="class_name" value="Lifting" class="hidden-radio" onchange="updateSelection(this)">
                                <i class="fas fa-dumbbell" style="font-size: 2rem; color: #4facfe; margin-bottom: 10px;"></i>
                                <div style="font-weight: 600;">Lifting</div>
                            </label>

                            <!-- Crossfit -->
                            <label class="sport-card" style="display: block; padding: 1.5rem; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); border-radius: 12px; cursor: pointer; transition: 0.3s; text-align: center;">
                                <input type="radio" name="class_name" value="Crossfit" class="hidden-radio" onchange="updateSelection(this)">
                                <i class="fas fa-running" style="font-size: 2rem; color: #ff9f43; margin-bottom: 10px;"></i>
                                <div style="font-weight: 600;">Crossfit</div>
                            </label>

                        </div>
                    </div>

                    <!-- KOLOM KANAN: Detail Reservasi -->
                    <div>
                        <h3 style="margin-bottom: 1.5rem; font-size: 1.2rem; border-bottom: 2px solid var(--primary-color); display: inline-block; padding-bottom: 5px;">2. Detail Jadwal</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                            
                            <!-- Nama (Readonly karena sudah login) -->
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-size: 0.9rem;">Nama Member</label>
                                <input type="text" name="name" 
                                       value="{{ Auth::user()->name }}" 
                                       readonly
                                       style="width: 100%; padding: 1rem; background: rgba(255,255,255,0.05); border: 1px solid var(--glass-border); color: rgba(255,255,255,0.6); border-radius: 8px; cursor: not-allowed;">
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-size: 0.9rem;">Tanggal Reservasi</label>
                                <input type="date" name="date" required 
                                       style="width: 100%; padding: 1rem; background: rgba(255,255,255,0.1); border: 1px solid var(--glass-border); color: white; border-radius: 8px; outline: none; transition: 0.3s;" 
                                       onfocus="this.style.borderColor='var(--primary-color)'"
                                       onblur="this.style.borderColor='var(--glass-border)'">
                            </div>

                            <!-- Waktu -->
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-size: 0.9rem;">Waktu Mulai</label>
                                <select name="time" required style="width: 100%; padding: 1rem; background: rgba(255,255,255,0.1); border: 1px solid var(--glass-border); color: white; border-radius: 8px; outline: none;">
                                    <option value="" disabled selected>Pilih Jam</option>
                                    <option value="07:00">07:00 AM</option>
                                    <option value="09:00">09:00 AM</option>
                                    <option value="13:00">01:00 PM</option>
                                    <option value="16:00">04:00 PM</option>
                                    <option value="19:00">07:00 PM</option>
                                </select>
                            </div>

                            <!-- Catatan Tambahan -->
                            <div>
                                <label style="display: block; margin-bottom: 8px; font-size: 0.9rem;">Catatan Tambahan (Opsional)</label>
                                <textarea name="notes" rows="3" style="width: 100%; padding: 1rem; background: rgba(255,255,255,0.1); border: 1px solid var(--glass-border); color: white; border-radius: 8px; outline: none;" placeholder="Contoh: Saya pemula..."></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn-glass" style="width: 100%; padding: 1rem; font-size: 1.1rem; background: var(--primary-color); color: #1a1a2e; font-weight: 700; margin-top: 1rem;">
                                <i class="fas fa-calendar-check"></i> Konfirmasi Reservasi
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        // Script sederhana untuk efek visual saat memilih kelas
        function updateSelection(radio) {
            document.querySelectorAll('.sport-card').forEach(card => {
                card.style.background = 'rgba(255,255,255,0.05)';
                card.style.borderColor = 'var(--glass-border)';
                card.style.boxShadow = 'none';
            });
            
            const selectedCard = radio.closest('.sport-card');
            selectedCard.style.background = 'rgba(0, 242, 254, 0.2)';
            selectedCard.style.borderColor = 'var(--primary-color)';
            selectedCard.style.boxShadow = '0 0 15px rgba(0, 242, 254, 0.4)';
        }
        
        // Jalankan saat load untuk menandai pilihan default
        document.addEventListener('DOMContentLoaded', () => {
            const defaultRadio = document.querySelector('input[name="class_name"]:checked');
            if(defaultRadio) updateSelection(defaultRadio);
        });
    </script>
@endsection