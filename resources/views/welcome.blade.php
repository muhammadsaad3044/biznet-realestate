<script>
    const socket = new WebSocket('wss://api.biznetusa.com:3000');

    socket.onopen = () => {
        console.log('WebSocket connected');
    };

    socket.onerror = (error) => {
        console.error('WebSocket error:', error);
    };

    socket.onmessage = (event) => {
        console.log('Message from server:', event.data);
    };

    socket.onclose = () => {
        console.log('WebSocket connection closed');
    };
</script>
