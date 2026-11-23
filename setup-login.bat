@echo off
echo ============================================
echo   DEL OLYMPIC — Setup Database & Server
echo ============================================
echo.

cd /d "c:\laragon\www\Del Olimpyc\DelOlympic"

echo [1/4] Memastikan Laragon MySQL aktif...
echo        Pastikan Laragon sudah dibuka dan MySQL berjalan (lampu hijau)
echo.
pause

echo [2/4] Menjalankan migrasi database...
php artisan migrate
echo.

echo [3/4] Menjalankan seeder (akun demo)...
php artisan db:seed
echo.

echo [4/4] Menjalankan server lokal...
echo        Buka browser: http://localhost:8000/masuk
echo.
php artisan serve
