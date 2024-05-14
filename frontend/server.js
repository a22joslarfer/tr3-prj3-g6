import express from "express";
import { createServer } from "http";
import { Server } from "socket.io";
import cors from "cors";
import sqlite3Module from 'sqlite3';
import { v4 as uuidv4 } from 'uuid';

const sqlite3 = sqlite3Module.verbose();
const db = new sqlite3.Database('./chat.db');

// Create messages table if not exists
db.serialize(() => {
  db.run("CREATE TABLE IF NOT EXISTS messages (id INTEGER PRIMARY KEY AUTOINCREMENT, senderId TEXT, receiverId TEXT, text TEXT, timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
});

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
let rooms = {};
let socket_senderId = null;
let current_p2p_room = null;
let index = 0;
let chattingWithIdSocket = null;
let chattingWithIdIsConnected = false;


io.on('connection', (socket) => {
  console.log('A user connected with socket ID:', socket.id);

  socket.on('userJoined', (clientId) => {
    users[clientId] = socket.id;
    console.log('User with ID', clientId, 'joined');
  });

  socket.on('joinRoomWith', (chattingWithId, socket_userId) => {
    // guardar el socket del usuario con el que se va a chatear
    chattingWithIdSocket = users[chattingWithId];
    // guardar el id del usuario que envia el evento
    socket_senderId = socket_userId;
    console.log('test socket_senderId ' + socket_senderId + ' test socket_userId ' + socket_userId + '\n\n');
    console.log('chattingWithIdSocket: ', chattingWithIdSocket, '\n\n');
    // si el usuario con el que se va a chatear esta conectado
    if (chattingWithIdSocket) {
      // buscar o crear la sala de chat
      current_p2p_room = findOrCreateRoom(socket_userId, chattingWithId);
      // guardar la sala de chat en la lista de salas
      rooms[index] = current_p2p_room;
      index++;
      // unir al usuario que envia el evento a la sala de chat
      socket.join(current_p2p_room);
      console.log('User: ' + socket_userId + ' with socket:', socket.id, ' joined room: ', current_p2p_room);

      // mandar el id de la sala de chat a los usuarios que se van a conectar
      io.to(socket).emit('getRoomId', current_p2p_room);
      io.to(chattingWithIdSocket).emit('getRoomId', current_p2p_room);
      chattingWithIdIsConnected = true;
    } else {
      console.log('User', chattingWithId, 'is not currently connected');
    }

    if (socket === chattingWithIdSocket && chattingWithIdIsConnected === false) {
      io.to(chattingWithIdSocket).emit('getRoomId', current_p2p_room);
    }

    console.log('users: ', users, '\n\n');
    console.log('rooms: ', rooms, '\n\n');
  });

  function findOrCreateRoom(userId1, userId2) {
    let roomId;

    for (let id in rooms) {
      if (rooms[id].includes(userId1) && rooms[id].includes(userId2)) {
        roomId = id;
        break;
      }
    }

    if (!roomId) {
      roomId = uuidv4();
      rooms[roomId] = [userId1, userId2];
      console.log('Room ', roomId, 'for users', userId1, 'and', userId2, 'has been created');
    }

    return roomId;
  }
  
    socket.on('privateMessage', ({ from, to, text }) => {
      if (!users[to]) {
        console.log('User', to, 'is not currently connected. Storing message in database...');
        storeMessageInDatabase(socket.id, to, text);
      }
      io.to(current_p2p_room).emit('privateMessageReceived', { text, from: from });
      console.log('message from user: ' + from + ' with socket:' + socket.id, ' to room: ', current_p2p_room, 'to', to + '\n\n');
    });

  socket.on('leaveRoom', () => {
    socket.leave(current_p2p_room);
    console.log('User', socket.id, 'left room', current_p2p_room);
    // If the room is empty, delete it
    if (io.sockets.adapter.rooms.get(current_p2p_room).size === 0) {
      delete rooms[current_p2p_room];
      console.log('Room', current_p2p_room, 'is now empty and has been deleted');
    }
  });

  socket.on('disconnect', () => {
    delete users[socket.id];
    console.log('User with socket ID', socket.id, 'disconnected');

    for (let id in rooms) {
      if (rooms[id].includes(socket.id)) {
        rooms[id] = rooms[id].filter(userId => userId !== socket.id);

        if (rooms[id].length === 0) {
          delete rooms[id];
          console.log('Room', id, 'is now empty and has been deleted');
        }
      }
    }
  });

});

function storeMessageInDatabase(senderId, receiverId, text) {
  db.run("INSERT INTO messages (senderId, receiverId, text) VALUES (?, ?, ?)", [senderId, receiverId, text], (err) => {
    if (err) {
      console.error('Error storing message:', err);
    } else {
      console.log('Message stored in database.');
    }
  });
}

server.listen(5000, () => {
  console.log('Server running at http://elysium.daw.inspedralbes.cat:5000');
});
