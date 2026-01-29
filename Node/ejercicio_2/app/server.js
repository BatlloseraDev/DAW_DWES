import express from 'express';
import cors from 'cors';
import chalk from 'chalk'; // Opcional, si quieres colores
// Importamos las rutas que creamos en el paso anterior
import gameRoutes from '../routes/gameRoutes.js'
import {router as userRoutes} from '../routes/userRoutes.js'
import {router as authRoutes} from '../routes/authRotues.js'

class Server {

    constructor() {
        this.app = express();
        this.port = process.env.PORT || 3000;

        // Definimos las rutas principales de nuestra API
        this.paths = {
            game: '/api/game',
            usuariosPath: '/api/usuario',
            authPath: '/api/auth',
        };

        // 1. Ejecutar Middlewares (siempre antes de las rutas)
        this.middlewares();

        // 2. Definir Rutas
        this.routes();
    }

    middlewares() {
        this.app.use(cors());
        this.app.use(express.json());    

    }

    routes() {
        //  URL /api/game
        this.app.use(this.paths.game, gameRoutes);
        this.app.use(this.paths.usuariosPath, userRoutes);
        this.app.use(this.paths.authPath, authRoutes);
    }

    listen() {
        this.app.listen(this.port, () => {
    
            console.log(chalk.green.bold(`🚀 Servidor corriendo en puerto ${this.port}`));
        });
    }
}

export { Server };