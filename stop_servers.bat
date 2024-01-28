@echo off

:: Stop WebSocket server
taskkill /F /FI "WINDOWTITLE eq WebSocket Server*"
echo "WebSocket server stopped."

:: Stop Ping server
taskkill /F /FI "WINDOWTITLE eq Ping Server*"
echo "Ping server stopped."

pause
