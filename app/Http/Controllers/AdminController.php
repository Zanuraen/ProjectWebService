<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // ============================================================
    // DASHBOARD OVERVIEW
    // ============================================================
    public function index()
    {
        // 1. Hitung Statistik
        $stats = [
            'users'    => User::count(),
            'bookings' => Booking::where('status', 'pending')->count(),
            'packages' => Package::count(),
            'posts'    => Post::count(),
            'revenue'  => Booking::sum('price')
        ];

        // 2. Ambil Data untuk Semua Tab
        $users    = User::latest()->take(10)->get();
        $bookings = Booking::latest()->take(10)->get();
        $packages = Package::all();
        $posts    = Post::latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'users', 'bookings', 'packages', 'posts'));
    }

    // ============================================================
    // MANAJEMEN USER
    // ============================================================
    public function users()
    {
        $stats = ['users' => User::count(), 'bookings' => Booking::where('status', 'pending')->count(), 'packages' => Package::count(), 'posts' => Post::count(), 'revenue' => Booking::sum('price')];
        $users = User::latest()->paginate(10);
        $bookings = collect();
        $packages = collect();
        $posts = collect();
        return view('admin.dashboard', compact('stats', 'users', 'bookings', 'packages', 'posts'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    // ============================================================
    // MANAJEMEN BOOKING (VERIFIKASI RESERVASI)
    // ============================================================
    public function bookings()
    {
        $stats = ['users' => User::count(), 'bookings' => Booking::where('status', 'pending')->count(), 'packages' => Package::count(), 'posts' => Post::count(), 'revenue' => Booking::sum('price')];
        $users = collect();
        $bookings = Booking::latest()->paginate(10);
        $packages = collect();
        $posts = collect();
        return view('admin.dashboard', compact('stats', 'users', 'bookings', 'packages', 'posts'));
    }

    public function updateBookingStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        // Update status
        $booking->status = $request->status;

        // FITUR BARU: Generate Kode Unik jika status Approved
        if ($request->status == 'approved' && empty($booking->reservation_code)) {
            // Format kode: GYM-XXXXXX
            $booking->reservation_code = 'GYM-' . strtoupper(\Illuminate\Support\Str::random(6));
        }

        $booking->save();
        return back()->with('success', 'Status booking diperbarui.');
    }

    // ============================================================
    // MANAJEMEN PAKET
    // ============================================================
    public function packages()
    {
        $stats = ['users' => User::count(), 'bookings' => Booking::where('status', 'pending')->count(), 'packages' => Package::count(), 'posts' => Post::count(), 'revenue' => Booking::sum('price')];
        $users = collect();
        $bookings = collect();
        $packages = Package::all();
        $posts = collect();
        return view('admin.dashboard', compact('stats', 'users', 'bookings', 'packages', 'posts'));
    }

    public function storePackage(Request $request)
    {
        $request->validate(['name' => 'required|string', 'type' => 'required|string', 'price' => 'required|numeric', 'features' => 'required|string', 'is_featured' => 'sometimes|boolean']);
        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');
        Package::create($data);
        return back()->with('success', 'Paket baru berhasil ditambahkan.');
    }

    public function updatePackage(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        $request->validate(['name' => 'required|string', 'type' => 'required|string', 'price' => 'required|numeric', 'features' => 'required|string']);
        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');
        $package->update($data);
        return back()->with('success', 'Paket berhasil diperbarui.');
    }

    public function deletePackage($id)
    {
        Package::destroy($id);
        return back()->with('success', 'Paket dihapus.');
    }
}