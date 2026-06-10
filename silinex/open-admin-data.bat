@echo off
setlocal

cd /d "%~dp0"

echo Starting Silinex website server...
echo.
echo Admin data viewer:
echo http://127.0.0.1:8080/admin-data
echo.
echo Password: admin123
echo.

start "Silinex PHP Server" /min php -S 127.0.0.1:8080 -t "%~dp0" "%~dp0router.php"
timeout /t 2 >nul
start "" "http://127.0.0.1:8080/admin-data"

echo If the browser does not open, copy this URL:
echo http://127.0.0.1:8080/admin-data
echo.
pause
