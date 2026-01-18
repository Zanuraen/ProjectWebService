@extends('layouts.app')

@section('content')
<div style="display: flex; height: calc(100vh - 80px); padding-top: 20px;">
    
    <!-- SIDEBAR -->
    <div class="glass" style="width: 250px; padding: 2rem; display: flex; flex-direction: column; gap: 1rem; margin-right: 20px;">
        <h3 style="color: var(--primary-color); margin-bottom:1rem;">ADMIN PANEL</h3>
        
        <button onclick="showTab('dashboard')" class="admin-tab" style="text-align: left; padding: 10px; background: none; border: none; color: white; cursor: pointer; border-radius: 8px;">
            <i class="fas fa-home"></i> Dashboard
        </button>
        <button onclick="showTab('bookings')" class="admin-tab" style="text-align: left; padding: 10px; background: none; border: none; color: white; cursor: pointer; border-radius: 8px;">
            <i class="fas fa-calendar-check"></i> Reservasi
        </button>
        <button onclick="showTab('users')" class="admin-tab" style="text-align: left; padding: 10px; background: none; border: none; color: white; cursor: pointer; border-radius: 8px;">
            <i class="fas fa-users"></i> Users
        </button>
        <button onclick="showTab('packages')" class="admin-tab" style="text-align: left; padding: 10px; background: none; border: none; color: white; cursor: pointer; border-radius: 8px;">
            <i class="fas fa-box-open"></i> Paket Member
        </button>
        <button onclick="showTab('posts')" class="admin-tab" style="text-align: left; padding: 10px; background: none; border: none; color: white; cursor: pointer; border-radius: 8px;">
            <i class="fas fa-newspaper"></i> Postingan
        </button>
        
        <div style="margin-top: auto;">
            <a href="{{ route('home') }}" style="color: #aaa; text-decoration: none; font-size: 0.9rem;">
                <i class="fas fa-arrow-left"></i> Kembali ke Web
            </a>
        </div>
    </div>

    <!-- CONTENT AREA -->
    <div style="flex: 1; padding-right: 20px; overflow-y: auto;">

        <!-- 1. TAB DASHBOARD -->
        <div id="tab-dashboard" class="admin-content" style="display: block;">
            <h2>Dashboard Overview</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
                <div class="glass" style="padding: 1.5rem; border-left: 4px solid var(--primary-color);">
                    <h3>{{ $stats['users'] ?? 0 }}</h3>
                    <p>Total User</p>
                </div>
                <div class="glass" style="padding: 1.5rem; border-left: 4px solid #ff4d4d;">
                    <h3>{{ $stats['bookings'] ?? 0 }}</h3>
                    <p>Booking Pending</p>
                </div>
                <div class="glass" style="padding: 1.5rem; border-left: 4px solid #00ff88;">
                    <h3>{{ $stats['packages'] ?? 0 }}</h3>
                    <p>Total Paket</p>
                </div>
                <div class="glass" style="padding: 1.5rem; border-left: 4px solid #f1c40f;">
                    <h3>{{ $stats['posts'] ?? 0 }}</h3> <!-- FIX ERROR BARIS 41 -->
                    <p>Total Postingan</p>
                </div>
            </div>
        </div>

        <!-- 2. TAB RESERVASI -->
        <div id="tab-bookings" class="admin-content" style="display: none;">
            <h2>Verifikasi Reservasi</h2>
            <div class="glass" style="margin-top: 1rem; padding: 1rem;">
                <table style="width: 100%; text-align: left; border-collapse: collapse; color: white;">
                    <tr style="border-bottom: 1px solid var(--glass-border); color: var(--primary-color);">
                        <th style="padding: 10px;">Nama</th>
                        <th style="padding: 10px;">Kelas</th>
                        <th style="padding: 10px;">Tanggal</th>
                        <th style="padding: 10px;">Status</th>
                        <th style="padding: 10px;">Aksi</th>
                    </tr>
                    @if(isset($bookings))
                        @foreach($bookings ?? collect() as $b)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td style="padding: 10px;">{{ $b->name }}</td>
                            <td style="padding: 10px;">{{ $b->class_name }}</td>
                            <td style="padding: 10px;">{{ $b->date }}</td>
                            <td style="padding: 10px;">
                                <span style="padding: 5px 10px; border-radius: 5px; font-size: 0.8rem; background: {{ $b->status == 'approved' ? '#00ff88' : ($b->status == 'rejected' ? '#ff4d4d' : '#f1c40f') }}; color: #000;">
                                    {{ ucfirst($b->status) }}
                                </span>
                            </td>
                            <td style="padding: 10px;">
                                <form action="{{ route('admin.updateBooking', $b->id) }}" method="POST">@csrf
                                    <select name="status" onchange="this.form.submit()" style="padding: 5px; border-radius: 5px;">
                                        <option value="pending" {{ $b->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $b->status == 'approved' ? 'selected' : '' }}>Terima</option>
                                        <option value="rejected" {{ $b->status == 'rejected' ? 'selected' : '' }}>Tolak</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>

        <!-- 3. TAB USERS -->
        <div id="tab-users" class="admin-content" style="display: none;">
            <h2>Manajemen User</h2>
            <div class="glass" style="margin-top: 1rem; padding: 1rem;">
                <table style="width: 100%; text-align: left; border-collapse: collapse; color: white;">
                    <tr style="border-bottom: 1px solid var(--glass-border); color: var(--primary-color);">
                        <th style="padding: 10px;">ID</th>
                        <th style="padding: 10px;">Nama</th>
                        <th style="padding: 10px;">Email</th>
                        <th style="padding: 10px;">Aksi</th>
                    </tr>
                    @if(isset($users))
                        @foreach($users ?? collect() as $u)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td style="padding: 10px;">{{ $u->id }}</td>
                            <td style="padding: 10px;">{{ $u->name }}</td>
                            <td style="padding: 10px;">{{ $u->email }}</td>
                            <td style="padding: 10px;">
                                <form action="{{ route('admin.deleteUser', $u->id) }}" method="POST" onsubmit="return confirm('Yakin hapus user ini?');">@csrf @method('DELETE')
                                    <button style="background: #ff4d4d; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>

        <!-- 4. TAB PAKET -->
        <div id="tab-packages" class="admin-content" style="display: none;">
            <h2>Manajemen Paket Member</h2>
            @if(session('success'))
                <div style="background: rgba(0,255,136,0.2); color: #00ff88; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="glass" style="padding: 1.5rem; margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 5px;">Tambah Paket Baru</h3>
                
                <form action="{{ route('admin.storePackage') }}" method="POST" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">@csrf
                    <div>
                        <label style="display:block; margin-bottom:5px;">Nama Paket</label>
                        <input type="text" name="name" placeholder="Contoh: Weekly Basic" required style="width: 100%; padding: 10px; background: rgba(255,255,255,0.1); color: white; border: 1px solid var(--glass-border); border-radius: 5px;">
                        <label style="display:block; margin-top:10px; margin-bottom:5px;">Tipe</label>
                        <input type="text" name="type" placeholder="Mingguan" required style="width: 100%; padding: 10px; background: rgba(255,255,255,0.1); color: white; border: 1px solid var(--glass-border); border-radius: 5px;">
                        <label style="display:block; margin-top:10px; margin-bottom:5px;">Harga</label>
                        <input type="number" name="price" placeholder="350000" required style="width: 100%; padding: 10px; background: rgba(255,255,255,0.1); color: white; border: 1px solid var(--glass-border); border-radius: 5px;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:5px;">Fitur</label>
                        <textarea name="features" rows="4" placeholder="- Akses Gym" required style="width: 100%; padding: 10px; background: rgba(255,255,255,0.1); color: white; border: 1px solid var(--glass-border); border-radius: 5px;"></textarea>
                        <div style="margin-top: 15px;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="is_featured" value="1" style="width: 20px; height: 20px;">
                                <span> Jadikan Rekomendasi?</span>
                            </label>
                        </div>
                    </div>
                    <div style="grid-column: span 2;">
                        <button type="submit" class="btn-glass" style="width: 100%; padding: 1rem; font-size: 1.1rem;">
                            <i class="fas fa-plus-circle"></i> Simpan Paket Baru
                        </button>
                    </div>
                </form>
            </div>

            <h3>Daftar Paket</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 1rem;">
                @if(isset($packages))
                    @foreach($packages ?? collect() as $p)
                    <div class="glass" style="padding: 1.5rem; position: relative; background: {{ $p->is_featured ? 'rgba(0, 242, 254, 0.1)' : '' }};">
                        <div style="position: absolute; top: 10px; right: 10px;">
                            <button onclick="deletePackage({{ $p->id }})" style="background: rgba(255,0,0,0.3); color: white; border: none; width: 25px; height: 25px; border-radius: 50%; cursor: pointer;">x</button>
                        </div>
                        <h3 style="color: var(--primary-color);">{{ $p->name }}</h3>
                        <p style="font-size: 0.9rem; color: #aaa;">{{ $p->type }}</p>
                        <h2 style="margin: 10px 0;">Rp {{ number_format($p->price, 0, ',', '.') }}</h2>
                        <form action="{{ route('admin.updatePackage', $p->id) }}" method="POST">@csrf @method('PUT')
                            <textarea name="features" style="width: 100%; background: rgba(255,255,255,0.05); color: white; border: none; padding: 5px; border-radius: 5px; margin-bottom: 5px; height: 60px;">{{ $p->features }}</textarea>
                            <button type="submit" style="width: 100%; padding: 8px; background: rgba(255,255,255,0.1); color: white; border: none; border-radius: 5px; cursor: pointer;">Simpan Perubahan</button>
                        </form>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- 5. TAB POSTINGAN -->
        <div id="tab-posts" class="admin-content" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2>Manajemen Postingan</h2>
                <a href="{{ route('admin.posts.create') }}" class="btn-glass" style="background: var(--primary-color); color: #1a1a2e;">
                    <i class="fas fa-plus"></i> Tambah Postingan
                </a>
            </div>

            <div class="glass" style="padding: 1rem;">
                <table style="width: 100%; text-align: left; border-collapse: collapse; color: white;">
                    <tr style="border-bottom: 1px solid var(--glass-border); color: var(--primary-color);">
                        <th style="padding: 10px;">Gambar</th>
                        <th style="padding: 10px;">Judul</th>
                        <th style="padding: 10px;">Aksi</th>
                    </tr>
                    @if(isset($posts))
                        @foreach($posts ?? collect() as $p)
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td style="padding: 10px;">
                                <img src="{{ asset('images/posts/' . $p->image) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                            </td>
                            <td style="padding: 10px;">{{ $p->title }}</td>
                            <td style="padding: 10px; display: flex; gap: 5px;">
                                <a href="{{ route('admin.posts.edit', $p->id) }}" style="background: #f1c40f; color: black; padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 0.8rem;">Edit</a>
                                <form action="{{ route('admin.posts.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus postingan ini?');">@csrf @method('DELETE')
                                    <button style="background: #ff4d4d; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; font-size: 0.8rem;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </table>
            </div>
        </div>

    </div>
</div>

<script>
    function showTab(tabName) {
        document.querySelectorAll('.admin-content').forEach(el => el.style.display = 'none');
        document.getElementById('tab-' + tabName).style.display = 'block';
    }

    function deletePackage(id) {
        if(confirm('Hapus paket ini?')) {
            const form = document.createElement('form');
            form.method = 'POST'; form.action = '/admin/packages/' + id;
            const csrf = document.createElement('input'); csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
            const method = document.createElement('input'); method.type = 'hidden'; method.name = '_method'; method.value = 'DELETE';
            form.appendChild(csrf); form.appendChild(method); document.body.appendChild(form); form.submit();
        }
    }
</script>
@endsection