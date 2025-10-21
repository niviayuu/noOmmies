@echo off
echo ========================================
echo FIX DATABASE STRUCTURE
echo ========================================
echo.
echo Script ini akan memperbaiki struktur database yang rusak
echo dengan menghapus dan membuat ulang database kedai_jus
echo.
echo Password MySQL akan diminta...
echo.
pause

echo Menjalankan script SQL...
C:\xampp\mysql\bin\mysql.exe -u root -p < "%~dp0fix_database_structure.sql"

if %errorlevel% equ 0 (
    echo.
    echo ========================================
    echo DATABASE BERHASIL DIPERBAIKI!
    echo ========================================
    echo.
    echo Database kedai_jus telah dibuat ulang dengan struktur yang benar
    echo Semua tabel dan view sudah tersedia tanpa subfolder
    echo.
    echo Silakan buka phpMyAdmin untuk memverifikasi struktur database
    echo.
) else (
    echo.
    echo ========================================
    echo TERJADI KESALAHAN!
    echo ========================================
    echo.
    echo Gagal menjalankan script SQL
    echo Periksa koneksi MySQL dan coba lagi
    echo.
)

pause
