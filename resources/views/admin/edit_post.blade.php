@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: center; padding: 2rem;">
    <div class="glass" style="width: 100%; max-width: 600px; padding: 2rem;">
        <h2 style="margin-bottom: 1.5rem;">Edit Postingan</h2>
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
                <label>Judul</label>
                <input type="text" name="title" value="{{ $post->title }}" required style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: none;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label>Ganti Gambar (Opsional)</label>
                <input type="file" name="image" style="width: 100%; margin-top: 5px;">
                <small style="color: #aaa;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label>Deskripsi</label>
                <textarea name="description" rows="5" required style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: none;">{{ $post->description }}</textarea>
            </div>

            <button type="submit" class="btn-glass" style="width: 100%;">Update</button>
            <a href="{{ route('admin.posts') }}" style="display: block; text-align: center; margin-top: 10px; color: #aaa; text-decoration: none;">Batal</a>
        </form>
    </div>
</div>
@endsection