const WebSocket = require('ws');
const wss = new WebSocket.Server({ port: 8080 });

wss.on('connection', (ws) => {
    console.log('Client connected');

    ws.on('message', (message) => {
        const decodedMessage = message.toString();
        console.log('Received:', decodedMessage);
        
        wss.clients.forEach((client) => {
            if (client.readyState === WebSocket.OPEN) {
                client.send(decodedMessage);
            }
        });
    });
});

console.log('WebSocket server is running on ws://localhost:8080');
