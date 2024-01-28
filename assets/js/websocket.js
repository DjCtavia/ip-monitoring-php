const SocketMessageType = {
    UPDATE_IP: 'update_ip'
};

const RECONNECT_DELAY = 3000; // 3 seconds delay, adjust as needed

function connectWebSocket() {
    const socket = new WebSocket('ws://localhost:' + WS_SERVER_PORT);

    socket.addEventListener('open', function (event) {
        console.log('Websocket connection opened');
    });

    socket.addEventListener('message', async function (event) {
        console.log(event);
        const data = await JSON.parse(event.data);

        // verify data variable contains type and message properties
        if (!data.type || !data.message) {
            console.log('Invalid data received from server: ', data);
            return;
        }

        if (data.type === SocketMessageType.UPDATE_IP) {
            console.log('IP address updated with: ', data.message);
        }
    });

    socket.addEventListener('close', function (event) {
        console.log('Websocket connection closed. Reconnecting...');
        setTimeout(connectWebSocket, RECONNECT_DELAY);
    });

    socket.addEventListener('error', function (event) {
        console.error('Websocket error:', event);
    });

    return socket;
}

let socket = connectWebSocket();