#!/bin/bash

echo "=================================="
echo "  CREATE ADMIN ACCOUNT (GYMNASTIC)"
echo "=================================="

read -p "Nama Admin   : " name
read -p "Email Admin  : " email
read -s -p "Password    : " password
echo ""

php artisan tinker --execute="
use App\Models\User;
use Illuminate\Support\Facades\Hash;

if (User::where('email', '$email')->exists()) {
    echo '❌ Email sudah terdaftar';
} else {
    User::create([
        'name' => '$name',
        'email' => '$email',
        'password' => Hash::make('$password'),
        'is_admin' => 1,
    ]);
    echo '✅ Akun admin berhasil dibuat';
}
"
