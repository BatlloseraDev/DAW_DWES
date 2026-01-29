import { MiServer } from './server.js';
import kleur from 'kleur';

try {
    const server = new MiServer();
    server.listen();
} catch (error) {
    console.error(kleur.red().bold("Error crítico al iniciar el servidor:"), error);
}