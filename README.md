🎮 GarasiGamer – Sistem Rental PlayStation Digital
📌 Latar Belakang
GarasiGamer adalah sistem manajemen rental PlayStation (PS3, PS4, PS5) berbasis web yang dirancang untuk membantu pemilik usaha rental game dalam mengelola unit PS, daftar game, transaksi penyewaan, serta memantau status setiap unit secara real-time. Sistem ini dikembangkan menggunakan framework Laravel dengan database MySQL, dan tampilan antarmuka menggunakan Tailwind CSS. Dengan adanya sistem ini, pemilik rental dapat memantau unit mana yang sedang digunakan, berapa lama sisa waktu sewa, serta mencatat pendapatan secara otomatis.

🎯 Tujuan Dibuatnya Web Ini
Memudahkan pencatatan transaksi sewa – dari pemilihan unit, durasi, hingga total harga dihitung otomatis.

Manajemen unit PS per tipe – setiap PS (PS3, PS4, PS5) memiliki unit yang bisa disewa independen (misal PS3 Unit 1, Unit 2).

Timer sisa waktu sewa – pelanggan dan admin bisa melihat countdown berapa lama lagi unit akan tersedia.

Pengelolaan daftar game – setiap tipe PS memiliki daftar game yang bisa ditambah, dihapus, atau diedit.

Riwayat transaksi dengan filter – admin bisa mencari transaksi berdasarkan tanggal, jam, dan tipe PS.

Keamanan akses admin – hanya admin yang terautentikasi (dengan session Laravel) bisa mengelola data.

Sidebar tersembunyi – antarmuka yang responsif dan nyaman digunakan di berbagai perangkat.

🧩 Fitur Lengkap Per Halaman
1. Halaman Login & Register
Autentikasi admin menggunakan Laravel Session.

Registrasi akun admin baru dengan validasi email unik dan konfirmasi password.

Setelah login, admin diarahkan ke Dashboard.

Keamanan: password di-hash dengan bcrypt, proteksi CSRF.

2. Dashboard – Status PS & Unit
Menampilkan semua tipe PS (PS3, PS4, PS5) dalam bentuk kartu.

Setiap kartu menampilkan:

Harga sewa per jam.

Jumlah unit tersedia dan sedang digunakan.

Progress bar kepadatan unit.

Daftar unit per tipe PS (misal PS3 Unit 1, Unit 2, dst) dengan status:

🟢 Hijau = Tersedia

🔴 Merah = Sedang disewa, lengkap dengan nama customer dan timer countdown sisa waktu sewa (real-time, update setiap detik via JavaScript).

Total rental aktif dihitung dan ditampilkan.

3. Manajemen Tipe PS & Stok
Admin dapat menambah tipe PS baru (nama, harga per jam, total unit).

Edit harga dan jumlah unit secara langsung (tombol + / - pada setiap kartu).

Hapus tipe PS (hanya jika tidak ada transaksi terkait).

Sistem otomatis menghitung unit yang tersedia (total unit - unit yang sedang aktif disewa).

Validasi: tidak bisa mengurangi unit jika sedang ada rental aktif di unit tersebut.

4. Manajemen Daftar Game
Setiap tipe PS memiliki koleksi game-nya sendiri (contoh: PS3 → GTA SA, BULLY, WinningEleven, dll).

Admin bisa menambah game baru ke tipe PS tertentu.

Admin bisa menghapus game dari daftar.

Game ditampilkan dalam bentuk badge yang rapi.

5. Transaksi Sewa (Form Rental)
Form pilihan Tipe PS (otomatis menampilkan harga per jam).

Setelah memilih tipe PS, dropdown Pilih Unit akan diisi dengan unit yang tersedia (yang tidak sedang disewa). Data diambil via AJAX.

Input Nama Customer.

Input Durasi Sewa (jam) – minimal 0.5 jam, step 0.5.

Kalkulasi harga otomatis – harga per jam × durasi, ditampilkan secara real-time saat durasi diubah.

Tombol Buat Transaksi → menyimpan data ke tabel rentals, status active, dan mengurangi ketersediaan unit.

Notifikasi sukses atau error (misal unit sudah terlanjur dipakai oleh admin lain).

6. Riwayat Transaksi
Menampilkan semua transaksi dalam bentuk tabel: Tanggal & jam, Tipe PS, Unit, Customer, Durasi, Total Bayar, Status.

Fitur filter:

Filter Tanggal (date picker)

Filter Jam (0-23)

Filter Tipe PS (PS3/PS4/PS5)

Aksi:

Tombol Kembalikan (untuk transaksi yang masih active). Klik tombol akan mengubah status menjadi completed dan melepaskan unit.

Klik baris transaksi untuk melihat detail (modal atau alert) – implementasi sederhana.

7. Sidebar Tersembunyi
Sidebar dapat dibuka/tutup dengan tombol burger menu (hamburger).

Berisi navigasi ke semua fitur: Dashboard, Tipe PS & Stok, Daftar Game, Sewa PS, Riwayat Transaksi, dan Logout.

Dirancang responsif untuk mobile dan desktop.

🛠️ Teknologi yang Digunakan
Komponen	Teknologi
Backend Framework	Laravel 13 (PHP 8.3+)
Database	MySQL (dikelola via Laragon / HeidiSQL)
Frontend	Tailwind CSS + FontAwesome
JavaScript	jQuery (untuk AJAX unit), Vanilla JS (timer)
Templating	Laravel Blade
Autentikasi	Laravel Session + Middleware custom (AdminMiddleware)
AJAX	jQuery.get() untuk mengambil unit tersedia
Realtime Timer	JavaScript setInterval dengan perhitungan selisih waktu
📂 Struktur Kode Penting
text
garasigamer/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/LoginController.php
│   │   │   ├── Auth/RegisterController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── PsTypeController.php
│   │   │   ├── GameController.php
│   │   │   ├── RentalController.php
│   │   └── Middleware/AdminMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── PsType.php
│   │   ├── Game.php
│   │   └── Rental.php
├── database/
│   ├── migrations/
│   │   ├── ..._create_users_table.php (bawaan)
│   │   ├── ..._add_is_admin_to_users_table.php
│   │   ├── ..._create_ps_types_table.php
│   │   ├── ..._create_games_table.php
│   │   ├── ..._create_rentals_table.php
│   │   └── ..._add_unit_number_to_rentals_table.php
│   └── seeders/DatabaseSeeder.php
├── resources/views/
│   ├── layouts/app.blade.php (sidebar tersembunyi)
│   ├── dashboard.blade.php
│   ├── ps_types/index.blade.php
│   ├── games/index.blade.php
│   ├── rentals/create.blade.php
│   └── rentals/history.blade.php
├── routes/web.php
└── .env
🔄 Alur Transaksi Rental (Lengkap)
Admin login.

Buka menu Sewa PS.

Pilih Tipe PS (contoh: PS3).

AJAX request ke server mengambil daftar unit yang tersedia dari unit yang total_units dikurangi rental aktif.

Admin pilih Unit (PS3 Unit 1 / Unit 2 / dst).

Isi nama customer, masukkan durasi (misal 3 jam).

Sistem hitung total = harga_per_jam × durasi.

Admin klik Buat Transaksi.

Backend validasi unit masih tersedia (mencegah race condition).

Simpan data ke tabel rentals dengan status active, unit_number, rental_date = now().

Redirect ke halaman Riwayat Transaksi.

Di dashboard, unit tersebut langsung berubah status menjadi merah, timer dimulai dari sisa waktu (rental_date + durasi).

Saat admin klik Kembalikan di riwayat, status menjadi completed, unit menjadi tersedia kembali.

📈 Keunggulan Sistem GarasiGamer
Manajemen unit independen – lebih detail daripada hanya menampilkan total unit.

Timer real-time – pelanggan dan admin tahu persis sisa waktu sewa tanpa harus hitung manual.

Pencegahan double booking – unit tidak bisa dipilih jika sudah aktif disewa.

Dashboard visual – memudahkan pemilik rental melihat kondisi semua unit sekilas.

Riwayat lengkap dengan filter – memudahkan audit dan rekap pendapatan.

Kode yang terstruktur – menggunakan MVC Laravel, mudah dikembangkan lebih lanjut.

🚀 Cara Menjalankan (Instalasi)
bash
# Clone atau buat project baru
composer create-project laravel/laravel garasigamer
cd garasigamer

# Konfigurasi database di .env
DB_DATABASE=garasigamer
DB_USERNAME=root
DB_PASSWORD=

# Migrasi dan seeder (jika ada)
php artisan migrate
php artisan db:seed   # (opsional, untuk data awal)

# Jika ada migration tambahan (unit_number)
php artisan migrate

# Jalankan server
php artisan serve
Akses http://127.0.0.1:8000/login
Akun default admin: admin@gg.com (atau yang dibuat saat register), password: rahasia123 (atau sesuai yang di-set via tinker).

💡 Pengembangan Lebih Lanjut (Bonus)
Laporan pendapatan per hari/bulan berdasarkan transaksi yang sudah selesai.

Notifikasi WhatsApp saat waktu sewa hampir habis.

Cetak struk atau nota sewa.

Multi-level user (kasir, owner) dengan hak akses berbeda.

Grafik pendapatan di dashboard.

Export riwayat transaksi ke Excel/PDF.

📝 Kesimpulan
GarasiGamer adalah sistem rental PlayStation yang siap digunakan untuk usaha skala kecil hingga menengah. Dengan fitur manajemen unit, timer sisa sewa, dan antarmuka yang bersih, sistem ini akan membantu pemilik rental mengelola bisnisnya secara lebih profesional. Proyek ini juga menjadi contoh implementasi Laravel yang baik dengan relasi antar tabel, penggunaan middleware, serta interaksi AJAX untuk pengalaman pengguna yang mulus.

