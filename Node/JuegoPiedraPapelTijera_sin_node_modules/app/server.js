import express from 'express';
import cors from 'cors';
import dotenv from 'dotenv';
import { createServer } from 'http';
import { Server } from 'socket.io';
import kleur from 'kleur';

import db from '../database/connection.js';
import { socketController } from '../controllers/websocket-controller.js';
import userRoutes from '../routes/userRoutes.js';

import '../model/associations.js';

// const app = express();
// const port = process.env.PORT || 8080;//fallback en caso de que falle por algun motivo


// //middlewares
// app.use(cors());
// app.use(express.json());
dotenv.config();

class MiServer {
    constructor() {
        this.app = express();

        //puertos
        this.port = process.env.PORT || 8080;//fallback en caso de que falle por algun motivo
        this.websocketPort = process.env.WEBSOCKETPORT || 8081;

        //paths
        this.paths = {
            users: '/api/users'//lo dejo asi por si luego quiero probar con mas rutas
        }

        //servidor para express
        this.serverExpress = createServer(this.app);
        //servidor paraa websockets
        this.serverWebSocket = createServer(this.app);

        //conf para socket io
        this.io = new Server(this.serverWebSocket, {
            cors: {
                origin: '*',//con esto permite la conexion desde cualquier origen
                methods: ['GET', 'POST']
            }
        });

        this.dbConnection();
        this.middlewares();
        this.routes();
        this.sockets();
    }

    async dbConnection() {
        try {
            //autenticar
            await db.authenticate();
            console.log(kleur.blue().bold('🔵 Base de datos online'));

            //sincronizar los modelos
            await db.sync({ force: false });
            //await db.sync({ force: false, alter: true });//con esto evita borrar datos y actualiza las columnas pero despues de unas cuantas veces peta...
            console.log(kleur.green().bold('📦 Modelos sincronizados'));
        } catch (error) {
            console.log(kleur.red().bold('💀 Error al conectar a la base de datos:'))
            console.error(error);
            //process.exit(1);
            //throw new Error(error);
        }

    }

    middlewares() {
        this.app.use(cors());
        this.app.use(express.json());
        //Direcotrio publico
        //this.app.use(express.static('public'));
    }

    routes() {
        this.app.use(this.paths.users, userRoutes);
    }

    sockets() {
        this.io.on('connection', (socket) => socketController(socket, this.io));
    }

    listen() {
        this.serverExpress.listen(this.port, () => {
            console.log(kleur.green().bold(`🟢 Servidor Express corriendo en puerto: ${this.port}`));
        });

        this.serverWebSocket.listen(this.websocketPort, () => {
            console.log(kleur.green().bold(`🟢 Servidor WebSocket corriendo en puerto: ${this.websocketPort}`));
        });
    }

}

export { MiServer };




