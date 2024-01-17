const SocketMessageType = {
    UPDATE_IP: 'update_ip'
};

document.addEventListener('DOMContentLoaded', () => {
    const socket = new WebSocket('ws://localhost:' + WS_SERVER_PORT)

    socket.addEventListener('open', function (event) {
        console.log('Websocket connection opened')
    });

    socket.addEventListener('message', async function (event) {
        const data = await JSON.parse(event.data)

        // verify data variable contains type and message properties
        if (!data.type || !data.message) {
            console.log('Invalid data received from server: ', data)
            return
        }

        if (data.type === SocketMessageType.UPDATE_IP) {
            console.log('IP address updated with: ', data.message)
        }
    });
})