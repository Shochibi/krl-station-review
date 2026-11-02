# KRL Station Review & Notes (2026 Edition)

Aplikasi web berbasis **Laravel 11**, **MySQL**, dan **Tailwind CSS** untuk direktori stasiun KRL Commuter Line terlengkap tahun 2026, ulasan komunitas anak kereta (anker), dan buku saku catatan pribadi (*private notes*).

---

## Fitur Utama

- **100 Stasiun KRL Terintegrasi (2026)**: Mencakup seluruh lin operasional aktif di Jabodetabek (Lin Bogor, Lin Cikarang, Lin Rangkasbitung, Lin Tangerang, Lin Tanjung Priok, Lin Bandara Soetta) dan Lin Yogyakarta-Solo.
- **Desain Otentik Komuter & Wayfinding Transit**: Mengadopsi visual signage papan stasiun KAI, kode singkatan stasiun resmi (MRI, THB, BOO, BKS, dsb.), dan palet warna resmi tiap lin.
- **Filter Jalur Interaktif**: Filter cepat per Lin KRL (dengan badge counter stasiun aktif), filter per kota/wilayah, dan opsi khusus stasiun transit antarmoda (MRT, LRT, Transjakarta).
- **Ulasan Publik Komunitas**: Rating 1-5 bintang, kategori ulasan (Fasilitas, Keramaian & Jam Padat, Kuliner & Kopi, Tips Transit & Posisi Gerbong, Kebersihan, Keamanan).
- **Buku Saku Komuter (Catatan Privat)**: Simpan tips posisi pintu gerbong, rekomendasi tempat parkir, dan catatan rahasia yang hanya bisa diakses oleh akun Anda.
- **Autentikasi & Responsif**: Manajemen akun (Breeze), UI mobile-first untuk kenyamanan komuter saat bepergian.

---

## Jaringan Lin & Stasiun yang Didukung (Tahun 2026)

1. **Lin Bogor (Red Line)**: Jakarta Kota s.d. Bogor & Percabangan Citayam - Pondok Rajeg - Nambo (28 stasiun)
2. **Lin Cikarang (Blue Line)**: Kampung Bandan - Pasar Senen - Jatinegara - Manggarai - Sudirman - Tanah Abang - Cikarang (26 stasiun)
3. **Lin Rangkasbitung (Green Line)**: Tanah Abang s.d. Rangkasbitung via Serpong, Cisauk, Jatake, Tenjo, Maja (19 stasiun)
4. **Lin Tangerang (Brown Line)**: Duri s.d. Tangerang via Rawa Buaya, Batu Ceper (10 stasiun)
5. **Lin Tanjung Priok (Pink Line)**: Jakarta Kota - Ancol - JIS (Jakarta International Stadium) - Tanjung Priok (3 stasiun)
6. **Lin Bandara Soekarno-Hatta (Basoetta)**: Terkoneksi Manggarai, BNI City, Duri, Batu Ceper, Bandara Soetta (1 stasiun terminus bandara)
7. **Lin Yogyakarta - Solo - Palur**: Yogyakarta (Tugu) s.d. Palur via Klaten & Solo Balapan (13 stasiun)

---

## Prasyarat & Lingkungan Pengembangan

- **PHP**: `^8.2` (XAMPP / native)
- **Database**: MySQL / MariaDB
- **Composer** (PHP Package Manager)
- **Node.js & NPM** (Build assets Vite & Tailwind CSS)

---

## Cara Instalasi & Menjalankan

1. **Clone Repositori & Masuk Folder**:
   ```bash
   cd krl-station-review
   ```

2. **Install Depedensi PHP & Node**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**:
   Salin file `.env.example` ke `.env` dan atur kredensial database MySQL Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=krl_review_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Migrasi Database & Seeder Seluruh Stasiun 2026**:
   ```bash
   php artisan migrate --seed
   ```

5. **Build Assets**:
   ```bash
   npm run build
   # atau untuk mode development:
   npm run dev
   ```

6. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Buka di peramban: `http://127.0.0.1:8000`
