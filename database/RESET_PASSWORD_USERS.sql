-- ============================================================
-- RESET PASSWORD DEFAULT USERS
-- Password untuk semua user: password
-- ============================================================

USE kedai_jus;

-- Update password untuk user admin, owner, dan karyawan
-- Password hash untuk: "password"
UPDATE users SET password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' 
WHERE email IN ('admin@kedaijus.com', 'owner@kedaijus.com', 'karyawan@kedaijus.com');

-- Pastikan status active
UPDATE users SET status = 'active' 
WHERE email IN ('admin@kedaijus.com', 'owner@kedaijus.com', 'karyawan@kedaijus.com');

-- Tampilkan hasil
SELECT id, nama_lengkap, email, role, status, 
       LEFT(password, 20) as password_hash,
       created_at
FROM users;

SELECT '========================================' as '';
SELECT 'Password berhasil di-reset!' as STATUS;
SELECT 'Email: admin@kedaijus.com' as '';
SELECT 'Password: password' as '';
SELECT '========================================' as '';

