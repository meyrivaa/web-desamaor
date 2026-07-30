@echo off
setlocal
cd /d "%~dp0"
title Website Desa Maor Laravel

if not exist "vendor\autoload.php" (
  echo Dependency belum terpasang.
  echo Jalankan dahulu 1-INSTAL-DAN-CEK.bat
  pause
  exit /b 1
)

echo Website akan tersedia di http://127.0.0.1:8000
echo Admin: http://127.0.0.1:8000/admin
echo Tekan Ctrl+C untuk menghentikan server.
echo.
php artisan serve
pause
