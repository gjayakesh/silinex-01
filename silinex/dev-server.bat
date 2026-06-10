@echo off
setlocal

:: Change to the directory of this script (silinex folder)
cd /d "%~dp0"

:: Start the PHP built‑in server
:: - Document root is this folder (so static assets work)
:: - Router script is silinex\router.php (relative to this folder)
php -S 127.0.0.1:8000 -t "%~dp0" "%~dp0router.php"

:: Keep console open after server stops
pause
