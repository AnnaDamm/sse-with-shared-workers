const ports = [];
onconnect = (event) => {
    // not handled: removing on disconnect.
    // workaround: check for response on messages, or send "ping" events from tabs and timeout tabs that dont send pings
    for (const port of event.ports) {
        ports.push(port);
        port.start();
    }
}

const eventSource = new EventSource('http://localhost:8000');
eventSource.onmessage = (event) => sendMessage('message', event.data);
eventSource.addEventListener('ping', (event) => sendMessage('ping', event.data));
eventSource.addEventListener('pong', (event) => sendMessage('pong', event.data));

function sendMessage(type, data) {
    for (const port of ports) {
        port.postMessage({
            type,
            data,
        });
    }
}
