@echo off

:: Start WebSocket server
start "WebSocket Server" php "src/Servers/RunWebsocketServer.php"
echo "WebSocket server started."

:: Start Ping server
start "Ping Server" php "src/Servers/RunPingServer.php"
echo "Ping server started."

pause
