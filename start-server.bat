@echo off
echo ========================================
echo  Resonance Development Server
echo ========================================
echo.

REM Check if PHP is in PATH
where php >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo PHP found in system PATH
    php -S localhost:8000
) else (
    REM Check if PHP exists in common location
    if exist "c:\Users\steve\Downloads\php-8.4.14-Win32-vs17-x64\php.exe" (
        echo Starting server with PHP from Downloads folder...
        "c:\Users\steve\Downloads\php-8.4.14-Win32-vs17-x64\php.exe" -S localhost:8000
    ) else (
        echo.
        echo ERROR: PHP not found!
        echo Please install PHP or add it to your system PATH.
        echo.
        echo Download PHP from: https://windows.php.net/download/
        echo.
        pause
        exit /b 1
    )
)
