import io from 'socket.io-client';

// Connect to the Socket.io server
export const socket = io('http://localhost:3113');