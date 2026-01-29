import dotenv from 'dotenv';
import { Server } from './server.js'; // Asegúrate que la ruta sea correcta

// 1. Cargar variables de entorno antes de nada
dotenv.config();

// 2. Instanciar el servidor
const server = new Server();

// 3. Ponerlo a escuchar
server.listen();