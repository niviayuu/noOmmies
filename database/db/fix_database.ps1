# ========================================
# FIX DATABASE STRUCTURE - PowerShell Script
# ========================================

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "FIX DATABASE STRUCTURE" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Script ini akan memperbaiki struktur database yang rusak" -ForegroundColor Yellow
Write-Host "dengan menghapus dan membuat ulang database kedai_jus" -ForegroundColor Yellow
Write-Host ""
Write-Host "Password MySQL akan diminta..." -ForegroundColor Red
Write-Host ""
Read-Host "Tekan Enter untuk melanjutkan"

try {
    Write-Host "Menjalankan script SQL..." -ForegroundColor Green
    
    # Get the directory of this script
    $scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path
    $sqlFile = Join-Path $scriptDir "fix_database_structure.sql"
    
    # Execute SQL script
    Get-Content $sqlFile | & "C:\xampp\mysql\bin\mysql.exe" -u root -p
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host ""
        Write-Host "========================================" -ForegroundColor Green
        Write-Host "DATABASE BERHASIL DIPERBAIKI!" -ForegroundColor Green
        Write-Host "========================================" -ForegroundColor Green
        Write-Host ""
        Write-Host "Database kedai_jus telah dibuat ulang dengan struktur yang benar" -ForegroundColor White
        Write-Host "Semua tabel dan view sudah tersedia tanpa subfolder" -ForegroundColor White
        Write-Host ""
        Write-Host "Silakan buka phpMyAdmin untuk memverifikasi struktur database" -ForegroundColor Cyan
        Write-Host ""
    } else {
        throw "MySQL command failed with exit code $LASTEXITCODE"
    }
} catch {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Red
    Write-Host "TERJADI KESALAHAN!" -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Red
    Write-Host ""
    Write-Host "Gagal menjalankan script SQL: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "Periksa koneksi MySQL dan coba lagi" -ForegroundColor Yellow
    Write-Host ""
}

Read-Host "Tekan Enter untuk keluar"
