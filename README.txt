KLINIKCARE - STARTER PROJECT PHP + MYSQL

Kebutuhan: XAMPP (Apache + MySQL), PHP 8+, browser.

INSTALASI
1. Ekstrak folder klinik_care ke C:\xampp\htdocs\
2. Jalankan Apache dan MySQL dari XAMPP.
3. Buka http://localhost/phpmyadmin
4. Import file database.sql.
5. Periksa config/database.php (default XAMPP: user root, password kosong).
6. Buat akun admin pertama dengan cara:
   - Buka phpMyAdmin > database klinik_care > SQL.
   - Jalankan query berikut setelah mengganti email/nama:
   INSERT INTO users(name,email,password_hash,role)
   VALUES ('Administrator','admin@klinikcare.test',
   '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.',
   'admin');
   Password contoh untuk hash di atas: password
   Segera ganti password setelah login. Jika hash tidak cocok pada instalasi PHP Anda,
   buat hash sendiri dengan PHP: echo password_hash('PasswordKuat123!', PASSWORD_DEFAULT);
   lalu masukkan hasilnya ke kolom password_hash.
7. Buka http://localhost/klinik_care

FITUR STARTER
- Login dengan role admin/dokter/pasien dan logout.
- Registrasi pasien.
- Dashboard ringkas sesuai role.
- Admin dapat menambah dokter, melihat pasien, dan melihat janji temu.
- Pasien dapat booking konsultasi dan melihat riwayat booking.
- Dokter dapat melihat daftar janji temu miliknya.

CATATAN PENTING
Ini adalah prototipe awal untuk pembelajaran, bukan sistem klinik siap produksi.
Sebelum dipakai sungguhan, perlu audit keamanan, HTTPS, backup, persetujuan privasi,
kontrol akses rekam medis lebih rinci, validasi jadwal bentrok, dan fitur pemeriksaan/
resep lengkap. Data medis adalah data sensitif; gunakan data dummy saat pengujian.
