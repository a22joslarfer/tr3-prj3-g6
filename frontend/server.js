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

let seats = [];
let connected = 0;

// Handle new connections
io.on('connection', (socket) => {
  console.log('CONNECTION:', {
    id: socket.id,
    connected: socket.connected,

  });
  connected++;
  io.emit('updateConnected', connected);
  console.log('USERS CONNECTED N:' + connected);
  socket.on('msg', (data) => {
    console.log('MSG:', data);
    io.emit('msg', data);
  });



  socket.on('addSeatToSeverSeatsArray', (data) => {
    // afegeix un objecte amb socket.id i seat.id a l'array
    seats.push({ socketId: socket.id, seatId: data });
    // envia al client un array amb els seat.id dels seients reservats
    console.log('Selected seats:', JSON.stringify(seats, null, 2));
    io.emit('updateSeats', seats);
  });

  socket.on('removeSeatFromServerSeatsArray', (data) => {
    // filtra l'array per eliminar l'objecte amb socket.id i seat.id iguals a data
    seats = seats.filter(seat => seat.socketId !== socket.id || seat.seatId !== data);
    // envia al client un array amb els seat.id dels seients reservats
    console.log('Selected seats:', JSON.stringify(seats, null, 2));
    io.emit('updateSeats', seats);
  });


  


  // Handle disconnections
  socket.on('disconnect', () => {
    console.log('DISCONNECTION:', {
      id: socket.id,
      disconnected: socket.disconnected,
    });
    connected--;
    // Elimina el contigut de l'array seats del socket que s'ha desconnectat
    seats = seats.filter(seat => seat.socketId !== socket.id);
    console.log('Selected seats:', JSON.stringify(seats, null, 2));
    io.emit('updateSeats', seats);
    io.emit('updateConnected', connected);
  });
});

server.listen(3113, () => {
  console.log('server running at http://localhost:3113');
});