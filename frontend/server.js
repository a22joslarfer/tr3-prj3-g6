import express from "express";
import { createServer } from "http";
import { Server } from "socket.io";
import cors from "cors";

const app = express();

const corsOptions = {
  origin: "*",
  methods: ["GET", "POST"],
  credentials: true,
};
app.use(cors(corsOptions));

const server = createServer(app);
const io = new Server(server, {
  cors: corsOptions,
});

let users = {};

io.on('connection', (socket) => {
  if (socket.request.headers.referer && socket.request.headers.referer.includes('hot-update.json')) {
    return;
  }

  socket.on('userJoined', (userId) => {
    console.log('CONNECTION:', {
      id: socket.id,
      connected: socket.connected,
    });

    users[userId] = socket.id; 
    io.emit('updateConnectedUsers', Object.keys(users));
  });

  socket.on('sendPrivateMessage', (message, receiverId, senderId) => {
    const receiverSocketId = users[receiverId];
    const senderSocketId = users[senderId];
    console.log('sendPrivateMessage:', {
      message,
      receiverId,
      senderId,
      receiverSocketId,
      senderSocketId,
    });
    if (!receiverSocketId) {
      console.error('Receiver not found');
      return;
    }

    if (!senderSocketId) {
      console.error('Sender not found');
      return;
    }

    io.to(senderSocketId).emit('privateMessageSent', message, receiverId, senderId);
    io.to(receiverSocketId).emit('privateMessageReceived', message, senderId, receiverId);
  });

  socket.on('disconnect', () => {
    console.log('DISCONNECTION:', {
      id: socket.id,
      disconnected: socket.disconnected,
    });

    // Remove the disconnected user
    for (const [key, value] of Object.entries(users)) {
      if (value === socket.id) {
        delete users[key];
        break;
      }
    }
    io.emit('updateConnectedUsers', Object.keys(users));
  });
});


server.listen(5000, () => {
  console.log('server running at http://localhost:5000');
});
