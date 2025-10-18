# Makmur Mandiri Medika (PT3M)

Website perusahaan penyedia alat medis berkualitas tinggi dengan sistem manajemen produk yang modern dan user-friendly.

## 🏥 Tentang Proyek

**Makmur Mandiri Medika** adalah website perusahaan yang menyediakan solusi lengkap untuk kebutuhan alat medis. Website ini dibangun menggunakan Laravel 12 dengan desain modern, responsif, dan tema hijau lembut yang elegan.

### 🎯 Fitur Utama (Sprint 1)

#### 👥 Manajemen Akun & Akses
- ✅ Login/logout untuk Super Admin dan Admin
- ✅ Super Admin dapat menambahkan akun Admin baru
- ✅ Super Admin dapat melihat daftar semua Admin
- ✅ Sistem role-based access control

#### 📦 Manajemen Produk
- ✅ CRUD produk lengkap dengan field:
  - Nama produk
  - Harga
  - Deskripsi
  - Ukuran
  - Foto produk
  - Link e-Katalog (URL eksternal)
- ✅ CRUD kategori produk
- ✅ Upload dan manajemen gambar produk
- ✅ Tombol "Beli" mengarah ke link e-katalog

#### 🏠 Landing Page Modern
- ✅ Tampilan responsif dengan tema hijau lembut
- ✅ Hero section dengan tagline "Solution for Medical Devices"
- ✅ Pencarian produk berdasarkan nama/kategori
- ✅ Filter produk berdasarkan kategori dan brand
- ✅ Menampilkan produk unggulan
- ✅ Section brand dan partner
- ✅ Informasi kontak lengkap

#### 🧑‍💻 Admin Dashboard
- ✅ Dashboard dengan statistik lengkap
- ✅ Manajemen produk, kategori, dan brand
- ✅ Manajemen akun admin (Super Admin only)
- ✅ Upload dan kelola logo website
- ✅ Interface admin yang user-friendly

## 🛠️ Teknologi yang Digunakan

- **Framework**: Laravel 12 (PHP 8.2+)
- **Database**: MySQL
- **Frontend**: Bootstrap 5.3.3
- **Icons**: Font Awesome 6.4.0
- **Styling**: Custom CSS dengan tema hijau lembut
- **Authentication**: Laravel Breeze

## 📋 Persyaratan Sistem

- PHP 8.2 atau lebih tinggi
- Composer
- MySQL 5.7 atau lebih tinggi
- Node.js & NPM (untuk asset compilation)

## 🚀 Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd makmur-mandiri-medika
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database**
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=makmur_mandiri_medika
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Jalankan migration dan seeder**
   ```bash
   php artisan migrate
   php artisan db:seed --class=SuperAdminSeeder
   php artisan db:seed --class=SampleDataSeeder
   ```

6. **Setup storage link**
   ```bash
   php artisan storage:link
   ```

7. **Jalankan server**
   ```bash
   php artisan serve
   ```

## 👤 Akun Default

### Super Admin
- **Email**: superadmin@makmurmandirimedika.com
- **Password**: password123

### Admin
- **Email**: admin@makmurmandirimedika.com
- **Password**: password123

## 📁 Struktur Proyek

```
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Controller untuk admin panel
│   │   └── Front/          # Controller untuk frontend
│   └── Models/             # Eloquent models
├── database/
│   ├── migrations/         # Database migrations
│   └── seeders/           # Database seeders
├── resources/
│   ├── views/
│   │   ├── admin/         # Views untuk admin panel
│   │   ├── front/         # Views untuk frontend
│   │   └── layouts/       # Layout templates
│   └── css/               # Custom CSS
└── routes/
    └── web.php            # Web routes
```

## 🎨 Tema & Desain

Website menggunakan tema hijau lembut yang elegan dengan kombinasi warna:
- **Primary Green**: #2d7d32
- **Light Green**: #4caf50
- **Soft Green**: #e8f5e8
- **Dark Green**: #1b5e20

Desain responsif dan modern dengan:
- Bootstrap 5 untuk layout dan komponen
- Font Awesome untuk icons
- Custom CSS untuk styling khusus
- Typography Inter untuk font yang clean

## 🔧 Fitur Admin Panel

### Dashboard
- Statistik produk, kategori, brand, dan admin
- Produk terbaru
- Admin terbaru (Super Admin only)
- Quick actions untuk aksi cepat

### Manajemen Produk
- Tambah, edit, hapus produk
- Upload gambar produk
- Set link e-katalog
- Manajemen status aktif/tidak aktif

### Manajemen User
- Tambah admin baru (Super Admin only)
- Edit data admin
- Hapus admin (Super Admin only)
- Sistem role-based access

## 🌐 URL Akses

- **Homepage**: `/`
- **Produk**: `/produk`
- **Login Admin**: `/login`
- **Dashboard Admin**: `/admin/dashboard`
- **Manajemen Produk**: `/admin/products`
- **Manajemen Admin**: `/admin/users` (Super Admin only)

## 📝 Catatan Pengembangan

### Sprint 1 - Completed ✅
- [x] Manajemen akun & akses
- [x] CRUD produk lengkap
- [x] CRUD kategori
- [x] Landing page modern
- [x] Admin dashboard
- [x] Tema hijau lembut
- [x] Pencarian & filter produk

### Sprint Selanjutnya (Planned)
- [ ] Fitur stok produk
- [ ] Keranjang belanja
- [ ] Checkout system
- [ ] Payment gateway
- [ ] Order management
- [ ] Email notifications
- [ ] Advanced search
- [ ] Product reviews
- [ ] Wishlist
- [ ] Multi-language support

## 🤝 Kontribusi

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

Proyek ini menggunakan lisensi MIT. Lihat file `LICENSE` untuk detail lebih lanjut.

## 📞 Kontak

**PT. Makmur Mandiri Medika**
- **Alamat**: Jl. Pendidikan, Komplek Pesona Cilebut 1 Blok. B2 No.3, Sukaraja, Bogor
- **Email**: info@makmurmandirimedika.com
- **Telepon**: +62 251 1234567

---

**Solution for Medical Devices** 🏥
