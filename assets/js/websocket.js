const SOCKET_CONNECTION_URL = 'ws://localhost:' + WS_SERVER_PORT;
const SocketMessageType = {
    UPDATE_IP: 'update_ip'
};

const socket = io(SOCKET_CONNECTION_URL);

socket.on('connect', () => {
    console.log('Websocket connection opened on: ')
});

socket.on('message', async (data) => {
    if (!data.type || !data.message) {
        console.log('Invalid data received from server: ', data)
        return
    }

    if (data.type === SocketMessageType.UPDATE_IP) {
        console.log('IP address updated with: ', data.message)
    }
});