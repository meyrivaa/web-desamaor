@echo off
setlocal
cd /d "%~dp0"
title Instal dan Cek Website Desa Maor Laravel

echo =============================================
echo INSTALASI WEBSITE DESA MAOR - LARAVEL
echo =============================================

where php >nul 2>nul
if errorlevel 1 (
  echo [ERROR] PHP tidak ditemukan di PATH.
  echo Pastikan PHP/Herd/XAMPP sudah aktif lalu buka terminal baru.
  pause
  exit /b 1
)

where composer >nul 2>nul
if errorlevel 1 (
  echo [ERROR] Composer tidak ditemukan di PATH.
  pause
  exit /b 1
)

echo.
echo [1/4] Versi PHP
php -v

echo.
echo [2/4] Memasang dependency Composer
call composer install
if errorlevel 1 goto :gagal

echo.
echo [3/4] Membersihkan cache Laravel
php artisan optimize:clear
if errorlevel 1 goto :gagal

echo.
echo [4/4] Menjalankan pengujian
php artisan test
if errorlevel 1 goto :gagal

echo.
echo [BERHASIL] Proyek siap dijalankan.
echo Lanjutkan dengan membuka 2-JALANKAN-WEB.bat
pause
exit /b 0

:gagal
echo.
echo [GAGAL] Periksa pesan error di atas.
pause
exit /b 1
