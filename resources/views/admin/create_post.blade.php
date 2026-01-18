@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: center; padding: 2rem;">
    <div class="glass" style="width: 100%; max-width: 600px; padding: 2rem;">
        <h2 style="margin-bottom: 1.5rem;">Tambah Postingan Baru</h2>
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div style="margin-bottom: 1.5rem;">
                <label>Judul</label>
                <input type="text" name="title" required style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: none;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label>Upload Gambar</label>
                <input type="file" name="image" required style="width: 100%; margin-top: 5px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label>Deskripsi</label>
                <textarea name="description" rows="5" required style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: none;"></textarea>
            </div>

            <button type="submit" class="btn-glass" style="width: 100%;">Simpan</button>
            <a href="{{ route('admin.posts') }}" style="display: block; text-align: center; margin-top: 10px; color: #aaa; text-decoration: none;">Batal</a>
        </form>
    </div>
</div>
@endsection