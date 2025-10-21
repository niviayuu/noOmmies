<?php
/**
 * TEST PASSWORD HASH
 * File ini untuk test apakah password hash bekerja dengan benar
 * Akses: http://localhost/jusbaru/test_password.php
 */

echo "<h2>🔐 Test Password Hash</h2>";
echo "<hr>";

// Password yang akan di-test
$password_input = "password";

// Hash yang ada di database (dari SQL default)
$hash_from_db = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';

echo "<h3>1. Test Password Verify</h3>";
echo "Password Input: <strong>$password_input</strong><br>";
echo "Hash dari DB: <code>$hash_from_db</code><br>";
echo "Result: ";

if (password_verify($password_input, $hash_from_db)) {
    echo "<span style='color: green; font-weight: bold;'>✅ PASSWORD COCOK!</span><br>";
} else {
    echo "<span style='color: red; font-weight: bold;'>❌ PASSWORD TIDAK COCOK!</span><br>";
}

echo "<hr>";

// Generate hash baru
echo "<h3>2. Generate Hash Baru</h3>";
$new_hash = password_hash($password_input, PASSWORD_BCRYPT);
echo "Password: <strong>$password_input</strong><br>";
echo "Hash Baru: <code>$new_hash</code><br>";
echo "Verify: ";

if (password_verify($password_input, $new_hash)) {
    echo "<span style='color: green; font-weight: bold;'>✅ HASH VALID!</span><br>";
} else {
    echo "<span style='color: red; font-weight: bold;'>❌ HASH TIDAK VALID!</span><br>";
}

echo "<hr>";

// Test berbagai password
echo "<h3>3. Test Berbagai Password</h3>";
$test_passwords = ['password', 'admin123', '123456'];

foreach ($test_passwords as $test_pass) {
    $hash = password_hash($test_pass, PASSWORD_BCRYPT);
    echo "<strong>Password:</strong> $test_pass<br>";
    echo "<strong>Hash:</strong> <code>$hash</code><br><br>";
}

echo "<hr>";

// Koneksi ke database untuk cek user
echo "<h3>4. Cek User di Database</h3>";

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'kedai_jus';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    echo "<span style='color: red;'>❌ Koneksi database gagal: " . $conn->connect_error . "</span>";
} else {
    echo "<span style='color: green;'>✅ Koneksi database berhasil!</span><br><br>";
    
    $query = "SELECT id, nama_lengkap, email, role, status, password FROM users WHERE email IN ('admin@kedaijus.com', 'owner@kedaijus.com', 'karyawan@kedaijus.com')";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr style='background: #f0f0f0;'>";
        echo "<th>ID</th><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th>Password (20 char)</th><th>Test Login</th>";
        echo "</tr>";
        
        while ($row = $result->fetch_assoc()) {
            $test_login = password_verify('password', $row['password']);
            $login_status = $test_login ? "<span style='color: green;'>✅ OK</span>" : "<span style='color: red;'>❌ FAIL</span>";
            
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['nama_lengkap']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['role']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td><code>" . substr($row['password'], 0, 20) . "...</code></td>";
            echo "<td>$login_status</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<span style='color: orange;'>⚠️ Tidak ada user ditemukan!</span>";
    }
    
    $conn->close();
}

echo "<hr>";
echo "<h3>5. SQL Update untuk Fix Password</h3>";
echo "<pre style='background: #f5f5f5; padding: 15px; border: 1px solid #ddd;'>";
echo "-- Copy query ini dan jalankan di phpMyAdmin:\n\n";
echo "UPDATE users \n";
echo "SET password = '$new_hash',\n";
echo "    status = 'active'\n";
echo "WHERE email = 'admin@kedaijus.com';\n";
echo "</pre>";

echo "<hr>";
echo "<p><strong>📝 Catatan:</strong></p>";
echo "<ul>";
echo "<li>Jika semua test di atas OK tapi masih tidak bisa login, cek session & cookies browser</li>";
echo "<li>Coba clear browser cache dan cookies</li>";
echo "<li>Pastikan tidak ada typo di email dan password</li>";
echo "<li>Cek file <code>application/controllers/Auth.php</code> untuk debug lebih lanjut</li>";
echo "</ul>";

echo "<hr>";
echo "<p><a href='http://localhost/jusbaru/auth/login' style='padding: 10px 20px; background: #FF6B35; color: white; text-decoration: none; border-radius: 5px;'>🔓 Coba Login Sekarang</a></p>";
?>

