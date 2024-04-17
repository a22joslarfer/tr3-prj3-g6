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

let users = [];
io.on('connection', (socket) => {
  // Ignore connections from Nuxt HMR
  if (socket.request.headers.referer && socket.request.headers.referer.includes('hot-update.json')) {
    return;
  }

  console.log('CONNECTION:', {
    id: socket.id,
    connected: socket.connected,
  });

  socket.on('userJoined', (userId) => {
    users[userId] = socket.id;
    io.emit('updateConnectedUsers', Object.keys(users));
  });

  socket.on('disconnect', () => {
    console.log('DISCONNECTION:', {
      id: socket.id,
      disconnected: socket.disconnected,
    });

    // Remove the disconnected user
    users = Object.fromEntries(Object.entries(users).filter(([userId, socketId]) => socketId !== socket.id));
    io.emit('updateConnectedUsers', Object.keys(users));
  });
});

server.listen(5000, () => {
  console.log('server running at http://localhost:5000');
});