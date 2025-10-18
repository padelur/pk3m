# Dashboard Admin - Makmur Mandiri Medika

## 🎯 Overview

Dashboard admin yang modern dan user-friendly dengan sidebar navigation untuk mengelola website Makmur Mandiri Medika.

## 🎨 Fitur Desain

### Layout Admin
- **Sidebar Navigation**: Menu navigasi tetap di sisi kiri dengan tema hijau
- **Header**: Header dengan informasi user dan toggle sidebar (mobile)
- **Content Area**: Area konten utama yang responsif
- **Modern Cards**: Card design yang elegan dengan shadow dan border radius

### Tema Warna
- **Primary Green**: #2d7d32
- **Light Green**: #4caf50  
- **Dark Green**: #1b5e20
- **Soft Green**: #e8f5e8

## 📱 Responsive Design

- **Desktop**: Sidebar tetap terlihat, content area dengan margin kiri
- **Mobile**: Sidebar tersembunyi, bisa dibuka dengan toggle button
- **Tablet**: Layout menyesuaikan dengan ukuran layar

## 🧭 Menu Sidebar

### Menu Utama
1. **Dashboard** - Halaman utama dengan statistik
2. **Produk** - Manajemen produk
3. **Kategori** - Manajemen kategori produk
4. **Brand** - Manajemen brand
5. **Manajemen Admin** - Kelola admin (Super Admin only)
6. **Pengaturan** - Konfigurasi website

### Menu Tambahan
- **Lihat Website** - Link ke frontend
- **Logout** - Keluar dari admin panel

## 📊 Dashboard Features

### Statistics Cards
- **Total Produk**: Jumlah semua produk
- **Produk Aktif**: Produk yang aktif
- **Kategori**: Jumlah kategori
- **Brand**: Jumlah brand

### Recent Data
- **Produk Terbaru**: 5 produk terbaru dengan detail
- **Admin Terbaru**: 5 admin terbaru (Super Admin only)

### Quick Actions
- **Tambah Produk**: Link langsung ke form tambah produk
- **Tambah Kategori**: Link langsung ke form tambah kategori
- **Tambah Brand**: Link langsung ke form tambah brand
- **Tambah Admin**: Link langsung ke form tambah admin (Super Admin only)

## 🔒 Security Features

### Role-Based Access
- **Super Admin**: Akses penuh ke semua fitur
- **Admin**: Akses terbatas (tidak bisa manage user)

### Authentication
- Semua halaman admin memerlukan login
- Session management yang aman
- CSRF protection

## 🛠️ Technical Details

### Layout File
- **File**: `resources/views/layouts/admin.blade.php`
- **Extends**: Tidak extends layout lain
- **CSS**: Custom CSS dengan CSS variables
- **JS**: Bootstrap 5 + Custom JavaScript

### Components
- **Sidebar**: Fixed position, gradient background
- **Header**: Sticky header dengan user info
- **Cards**: Modern card design dengan hover effects
- **Tables**: Responsive tables dengan Bootstrap styling

### JavaScript Features
- **Sidebar Toggle**: Toggle sidebar di mobile
- **Auto Close**: Sidebar otomatis tertutup saat klik outside (mobile)
- **Responsive**: JavaScript untuk responsive behavior

## 📁 File Structure

```
resources/views/
├── layouts/
│   └── admin.blade.php          # Layout admin dengan sidebar
├── admin/
│   ├── dashboard.blade.php      # Dashboard utama
│   └── users/
│       ├── index.blade.php      # Daftar admin
│       ├── create.blade.php     # Form tambah admin
│       ├── edit.blade.php       # Form edit admin
│       └── show.blade.php       # Detail admin
```

## 🚀 Usage

### Akses Dashboard
1. Login sebagai admin/super admin
2. Klik "Dashboard Admin" di menu dropdown
3. Atau akses langsung: `/admin/dashboard`

### Navigasi
- Klik menu di sidebar untuk navigasi
- Gunakan breadcrumb untuk orientasi
- Quick actions untuk aksi cepat

### Mobile Usage
- Klik hamburger menu untuk buka sidebar
- Sidebar akan tertutup otomatis saat navigasi
- Touch-friendly interface

## 🎯 Benefits

### User Experience
- **Intuitive**: Navigasi yang mudah dipahami
- **Fast**: Loading cepat dengan optimasi
- **Responsive**: Bekerja di semua device
- **Modern**: Desain yang up-to-date

### Developer Experience
- **Maintainable**: Code yang terstruktur
- **Extensible**: Mudah ditambah fitur baru
- **Consistent**: Konsistensi design system
- **Documented**: Dokumentasi yang lengkap

## 🔄 Future Enhancements

### Planned Features
- [ ] Dark mode toggle
- [ ] Search functionality di sidebar
- [ ] Notification system
- [ ] Activity log
- [ ] Export/Import data
- [ ] Advanced filtering
- [ ] Bulk actions
- [ ] Real-time updates

---

**Dashboard Admin siap digunakan dengan desain modern dan fitur lengkap!** 🎉
