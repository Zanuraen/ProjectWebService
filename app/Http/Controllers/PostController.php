<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Halaman User: Lihat Postingan (List, Search, Pagination)
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Logika Pencarian & Pagination
        $posts = Post::when($search, function ($query, $search) {
                    return $query->where('title', 'like', "%{$search}%");
                  })
                  ->latest()
                  ->paginate(10); 

        return view('posts.index', compact('posts'));
    }

    /**
     * Halaman User: Baca Detail Postingan
     */
    public function show($id)
    {
        // Cari post berdasarkan ID, jika tidak ada return 404
        $post = Post::findOrFail($id);
        
        return view('posts.show', compact('post'));
    }

    /**
     * Halaman Admin: List Postingan
     */
    public function adminIndex()
    {
        // Mengambil data untuk tab admin
        $posts = Post::latest()->paginate(10);
        
        // Return ke view dashboard yang sudah ada
        $stats = ['users' => \App\Models\User::count(), 'bookings' => \App\Models\Booking::where('status', 'pending')->count(), 'packages' => \App\Models\Package::count(), 'posts' => \App\Models\Post::count()];
        $users = collect();
        $bookings = collect();
        $packages = collect();

        return view('admin.dashboard', compact('stats', 'users', 'bookings', 'packages', 'posts'));
    }

    /**
     * Halaman Form Create
     */
    public function create()
    {
        return view('admin.create_post');
    }

    /**
     * Simpan Postingan + Upload Gambar (Auto Folder)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Logika Buat Folder Otomatis
        $uploadPath = public_path('images/posts');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $imageName = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($uploadPath, $imageName);
        }

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.posts')->with('success', 'Postingan berhasil ditambahkan!');
    }

    /**
     * Halaman Form Edit
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.edit_post', compact('post'));
    }

    /**
     * Update Postingan (Gambar & Teks)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'image' => 'sometimes|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $post = Post::findOrFail($id);
        
        // Logika Buat Folder jika belum ada
        $uploadPath = public_path('images/posts');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Jika upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            $oldImage = public_path('images/posts/' . $post->image);
            if (file_exists($oldImage)) unlink($oldImage); 

            // Upload baru
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move($uploadPath, $imageName);
            $post->image = $imageName;
        }

        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        return redirect()->route('admin.posts')->with('success', 'Postingan berhasil diperbarui!');
    }

    /**
     * Hapus Postingan (Database + File Fisik)
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        // Hapus file fisik
        $imagePath = public_path('images/posts/' . $post->image);
        if (file_exists($imagePath)) unlink($imagePath);

        // Hapus dari database
        $post->delete();

        return back()->with('success', 'Postingan berhasil dihapus.');
    }
}