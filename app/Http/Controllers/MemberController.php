<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index()
    {
        // Ambil semua paket dari database
        $packages = Package::all();

        // Ambil riwayat booking user yang sedang login, diurutkan dari yang terbaru
        $bookings = Booking::where('user_id', Auth::id())
                           ->latest()
                           ->get();

        return view('member', compact('packages', 'bookings'));
    }
}