<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Menampilkan halaman form booking
     */
    public function index()
    {
        return view('booking');
    }

    /**
     * Menyimpan data booking baru ke database
     */
    public function store(Request $request)
    {
        // 1. Validasi Input dari Form
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'class_name'  => 'required|string',
            'date'        => 'required|date',
            'time'        => 'required',
            'notes'       => 'nullable|string', // Catatan boleh kosong
        ]);

        // 2. Simpan ke Database
        Booking::create([
            'user_id'     => Auth::id(),           // ID user yang sedang login
            'name'        => $validated['name'],   // Nama dari form
            'class_name'  => $validated['class_name'],
            'date'        => $validated['date'],
            'time'        => $validated['time'],
            'notes'       => $validated['notes'],
        ]);

        // 3. Redirect kembali ke halaman member dengan pesan sukses
        return redirect()->route('member')
                         ->with('success', 'Reservasi kelas ' . $validated['class_name'] . ' berhasil dikonfirmasi!');
    }
}