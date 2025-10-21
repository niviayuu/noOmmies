# 🔐 SOLUSI: Tidak Bisa Login

## ❗ Masalah
Login gagal meskipun email dan password sudah benar.

---

## 🔍 DIAGNOSA MASALAH

Kemungkinan penyebab:
1. ❌ Kolom `no_hp` belum ada (error sebelumnya)
2. ❌ Password hash tidak cocok
3. ❌ User status = 'inactive'
4. ❌ Session/cookies issue

---

## ✅ SOLUSI LENGKAP (Ikuti Step by Step)

### **STEP 1: Fix Kolom no_hp** ⚠️ (WAJIB!)

Jalankan query ini dulu di phpMyAdmin:

```sql
USE kedai_jus;

-- Tambah kolom no_hp jika belum ada
ALTER TABLE `users` 
ADD COLUMN `no_hp` VARCHAR(15) NULL AFTER `role`;
```

**Jika error "Duplicate column name"** → Skip, lanjut ke Step 2

---

### **STEP 2: Reset Password Default Users**

Di phpMyAdmin, jalankan query ini:

```sql
USE kedai_jus;

-- Update password dan status untuk default users
UPDATE users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    status = 'active'
WHERE email IN ('admin@kedaijus.com', 'owner@kedaijus.com', 'karyawan@kedaijus.com');

-- Cek hasilnya
SELECT id, nama_lengkap, email, role, status FROM users;
```

**Password untuk semua user:** `password`

---

### **STEP 3: Test Password Hash**

1. Buka browser, akses: **http://localhost/jusbaru/test_password.php**
2. File ini akan menampilkan:
   - ✅ Test password hash
   - ✅ Cek koneksi database
   - ✅ Cek semua user di database
   - ✅ Test login untuk setiap user

3. Pastikan semua kolom "Test Login" menunjukkan ✅ OK

---

### **STEP 4: Clear Browser Cache**

1. Tekan **Ctrl + Shift + Delete** (Chrome/Firefox)
2. Pilih:
   - ✅ Cookies and other site data
   - ✅ Cached images and files
3. Pilih "All time" atau "Semua waktu"
4. Klik **Clear data** / **Hapus data**

**ATAU** tekan **Ctrl + F5** untuk hard reload

---

### **STEP 5: Test Login**

1. Buka: **http://localhost/jusbaru/auth/login**
2. Login dengan:
   - **Email:** `admin@kedaijus.com`
   - **Password:** `password`
3. Klik **LOGIN**
4. ✅ **Harus berhasil!**

---

## 🛠️ ALTERNATIF: Import File SQL

Jika masih gagal, jalankan file SQL yang sudah saya buat:

### Di phpMyAdmin:

1. Pilih database `kedai_jus`
2. Tab **Import**
3. Pilih file: **`database/RESET_PASSWORD_USERS.sql`**
4. Klik **Go**
5. ✅ Password semua user akan di-reset

---

## 🐛 DEBUG MODE (Jika masih gagal)

### Aktifkan Error Display:

Edit file `index.php` di root project:

```php
define('ENVIRONMENT', 'development'); // Line 54
```

### Edit Auth Controller untuk Debug:

Tambahkan logging di `application/controllers/Auth.php`, setelah line 26:

```php
// DEBUG: Log login attempt
log_message('debug', 'Login attempt - Email: ' . $email);

$user = $this->User_model->login($email, $password);

// DEBUG: Log user found
if ($user) {
    log_message('debug', 'User found - ID: ' . $user->id . ', Status: ' . $user->status);
} else {
    log_message('debug', 'User not found or password wrong');
}
```

Cek log di: `application/logs/`

---

## 🔍 MANUAL CHECK DATABASE

Jalankan query ini untuk cek user:

```sql
SELECT 
    id,
    nama_lengkap,
    email,
    role,
    status,
    LEFT(password, 30) as password_hash,
    created_at
FROM users
WHERE email = 'admin@kedaijus.com';
```

**Pastikan:**
- ✅ Status = `active`
- ✅ Password dimulai dengan `$2y$10$`
- ✅ Email benar (tidak ada spasi)

---

## 🎯 QUICK FIX (All-in-One)

Copy dan jalankan semua query ini sekaligus:

```sql
USE kedai_jus;

-- 1. Fix kolom no_hp
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `no_hp` VARCHAR(15) NULL AFTER `role`;

-- 2. Reset password & activate users
UPDATE users 
SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    status = 'active'
WHERE email IN ('admin@kedaijus.com', 'owner@kedaijus.com', 'karyawan@kedaijus.com');

-- 3. Cek hasil
SELECT id, nama_lengkap, email, role, status, 
       LEFT(password, 20) as pass_hash
FROM users;
```

**Note:** Jika error "IF NOT EXISTS", hapus bagian itu dan jalankan ulang.

---

## ✅ VERIFICATION CHECKLIST

Sebelum coba login, pastikan:

- [ ] Kolom `no_hp` sudah ada di tabel `users`
- [ ] Password users sudah di-reset
- [ ] Status users = `active`
- [ ] Browser cache sudah di-clear
- [ ] Tidak ada typo di email (periksa spasi)
- [ ] Password = `password` (lowercase, tanpa spasi)

---

## 📞 JIKA MASIH GAGAL

1. **Jalankan test_password.php** - Cek hasilnya
2. **Screenshot error** yang muncul
3. **Cek application/logs/** - Ada error log?
4. **Coba browser lain** (Firefox, Chrome, Edge)
5. **Coba mode Incognito/Private**

---

## 🔐 CREATE USER BARU MANUAL

Jika semua gagal, buat user baru manual:

```sql
-- Hapus user lama
DELETE FROM users WHERE email = 'admin@kedaijus.com';

-- Buat user baru
INSERT INTO users (nama_lengkap, email, password, role, no_hp, status) 
VALUES (
    'Administrator',
    'admin@kedaijus.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin',
    '081234567890',
    'active'
);

-- Test
SELECT * FROM users WHERE email = 'admin@kedaijus.com';
```

Login dengan:
- Email: `admin@kedaijus.com`
- Password: `password`

---

**File Bantuan yang Sudah Dibuat:**
- ✅ `test_password.php` - Test password & database
- ✅ `database/RESET_PASSWORD_USERS.sql` - Reset password otomatis
- ✅ `LOGIN_FIX_GUIDE.md` - Panduan lengkap ini

**Ikuti step by step dari atas, pasti berhasil! 🚀**

