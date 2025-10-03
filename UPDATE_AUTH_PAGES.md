# Update Authentication Pages

## 📋 Perubahan yang Dilakukan

### 1. **Perbaikan Background Image**
Background image sekarang berada di paling belakang (di body element), bukan di container form.

**Perubahan:**
- Background dipindah ke `body` dengan `z-index: -1`
- Form container tetap di depan dengan background semi-transparent
- Background image fixed (tidak scroll)
- Overlay gradient lebih terlihat

**File yang diupdate:**
- `resources/views/filament/pages/auth/login.blade.php`
- `resources/views/filament/pages/auth/register.blade.php`

---

### 2. **Form Registrasi Khusus Mahasiswa**
Form register sekarang sesuai dengan mockup - hanya untuk pendaftaran mahasiswa.

**Field yang tersedia:**
1. ✅ Nama Lengkap
2. ✅ Email  
3. ✅ Password
4. ✅ Konfirmasi Password
5. ✅ NIM (dengan validasi unique)
6. ✅ Prodi (dropdown dengan 8 pilihan)
7. ✅ Semester (default: 5)

**Dropdown Prodi:**
- D3 Agroindustri
- D3 Akuntansi
- D3 Teknologi Informasi
- D3 Teknologi Otomotif
- D4 Teknologi Rekayasa Komputer Jaringan
- D4 Teknologi Pakan Ternak
- D4 Teknologi Rekayasa Konstruksi Jalan dan Jembatan
- D4 Teknologi Rekayasa Pemeliharaan Alat Berat

**Features:**
- Searchable dropdown untuk prodi
- Validasi NIM unique (tidak boleh duplikat)
- Auto-create profile mahasiswa saat register
- Role otomatis set ke `mahasiswa`
- Transaction untuk memastikan data konsisten

**File yang diupdate:**
- `app/Filament/Auth/Register.php`

---

## 🎨 Visual Improvements

### Login Page
```
- Background: Gambar kampus
- Overlay: Gradient hijau-biru (85% opacity)
- Form: White card dengan backdrop blur
- Shadow: Deep shadow untuk depth
```

### Register Page
```
- Heading: "Daftar Mahasiswa"
- Background: Sama dengan login page
- Form: 7 fields (sesuai mockup)
- Dropdown: Searchable dengan 8 pilihan prodi
```

---

## 🔒 Security & Validation

1. **Email:** Required, valid email format
2. **NIM:** Required, unique, max 50 characters
3. **Password:** Required, confirmed
4. **Prodi:** Required, must be one of 8 options
5. **Semester:** Required, numeric, 1-14

---

## 💾 Database

Saat register berhasil:
1. Create record di table `users`:
   - name
   - email
   - password (hashed)
   - role = 'mahasiswa'

2. Create record di table `mahasiswa_profiles`:
   - user_id (FK to users)
   - nim
   - prodi
   - semester

---

## 🚀 Testing

```bash
# Clear cache
php artisan view:clear
php artisan config:clear

# Jalankan server
php artisan serve

# Test register
http://localhost:8000/dashboard/register

# Test login
http://localhost:8000/dashboard/login
```

---

## 📝 Notes

- Register sekarang **HANYA untuk Mahasiswa**
- Untuk membuat akun Dospem/Admin, gunakan:
  1. Database seeder
  2. Artisan command
  3. Admin panel (menu Kelola Akun)
  
- Background image responsive dan fixed
- Form validation real-time menggunakan Filament

---

**Updated:** 2 Oktober 2025  
**Status:** ✅ Production Ready


