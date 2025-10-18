const express = require('express');
const app = express();
const http = require('http').Server(app);
const io = require('socket.io')(http, {
    cors: {
        origin: [
            "http://localhost:3000",
            "http://127.0.0.1:8000",
            "https://api.biznetusa.com",
            "https://frontendzahrarealestate.vercel.app"
        ],
        methods: ["GET", "POST"],
        credentials: true
    }
});
const mysql = require('mysql');
const moment = require('moment');

let sockets = {};

// MySQL connection pool (recommended for production)
const pool = mysql.createPool({
    connectionLimit: 10, // Adjust based on your needs
    host: '127.0.0.1',
    user: 'u594879843_api',
    password: 'bEqpp29TqGLD4r2',
    database: 'u594879843_api',
    charset: 'utf8mb4' // Recommended for full UTF-8 support
});

// Handle WebSocket connections
io.on('connection', (socket) => {
    const userId = socket.handshake.query.user_id;

    if (!sockets[userId]) {
        sockets[userId] = [];
    }
    sockets[userId].push(socket);

    console.log(`User connected: ${userId}`);
    socket.emit('user_connected', userId);

    // Handle sending messages
    socket.on('send_message', (data) => {
        const time = moment().format("h:mm A");
        data.time = time;

        pool.query(
            `INSERT INTO chats (sender_id, receiver_id, message, created_at) VALUES (?, ?, ?, NOW())`,
            [data.sender_id, data.receiver_id, data.message],
            (err, result) => {
                if (err) {
                    console.error('Error inserting message:', err);
                    return;
                }

                data.id = result.insertId;

                // Send message to the receiver
                if (sockets[data.receiver_id]) {
                    sockets[data.receiver_id].forEach((receiverSocket) => {
                        receiverSocket.emit('receive_message', data);
                    });
                }

                // Acknowledge the sender
                if (sockets[data.sender_id]) {
                    sockets[data.sender_id].forEach((senderSocket) => {
                        senderSocket.emit('message_sent', data);
                    });
                }
            }
        );
    });

    // Handle disconnection
    socket.on('disconnect', () => {
        const index = sockets[userId]?.indexOf(socket);
        if (index !== -1) {
            sockets[userId].splice(index, 1);
        }

        if (sockets[userId]?.length === 0) {
            delete sockets[userId];
            console.log(`User disconnected: ${userId}`);
        }
    });
});

// Gracefully handle MySQL connection issues
pool.on('error', (err) => {
    console.error('MySQL Pool Error:', err);
});

// Start the server
http.listen(3000, () => {
    console.log('Web Socket is running 3000');
});
