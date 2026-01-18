<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Fungsi ini dijalankan saat Anda mengetik 'php artisan db:seed'
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Weekly Basic',
                'type' => 'Mingguan',
                'price' => 350000,
                'features' => "Akses Gym Lengkap\nKunci Loker\nTanpa Pelatih Pribadi",
                'is_featured' => false,
            ],
            [
                'name' => 'Weekly + Protein',
                'type' => 'Mingguan',
                'price' => 500000,
                'features' => "Akses Gym Lengkap\nKunci Loker\n1 Botol Whey Protein\nTanpa Pelatih Pribadi",
                'is_featured' => false,
            ],
            [
                'name' => 'Weekly Deluxe',
                'type' => 'Mingguan',
                'price' => 750000,
                'features' => "Akses Gym VIP\n2x Sesi Personal Trainer\nAsupan Protein Lengkap\nKonsultasi Nutrisi",
                'is_featured' => true, // Paket ini akan muncul dengan label REKOMENDASI
            ],
            [
                'name' => 'Bulanan',
                'type' => 'Bulanan',
                'price' => 1500000,
                'features' => "Akses Unlimited\nBisa Booking Kelas (Yoga/Cardio)\nGratis Kunci Loker",
                'is_featured' => false,
            ],
            [
                'name' => 'Tahunan',
                'type' => 'Tahunan',
                'price' => 14000000,
                'features' => "Semua Fitur Bulanan\nMember VVIP Priority\nGratis 1 Bulan Tambahan\nBisa Pause Membership",
                'is_featured' => false,
            ],
        ];

        // Loop data array dan masukkan ke database
        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}