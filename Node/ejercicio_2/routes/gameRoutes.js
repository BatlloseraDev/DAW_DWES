import { Router } from 'express';
import gameController from '../controllers/gameController.js';
import { validateStartGame, validateAttempt } from '../middlewares/game-validator.js';
import { validarJWT } from '../middlewares/validarJWT.js';
import { esUsuario } from '../middlewares/validarRoles.js';


const router = Router();

// Ruta para iniciar juego
// POST http://localhost:3000/api/game/start
router.post('/start', [validateStartGame, validarJWT, esUsuario], gameController.startNewGame);

// Ruta para enviar una palabra (intento)
// POST http://localhost:3000/api/game/attempt
router.post('/attempt', [validateAttempt, validarJWT, esUsuario], gameController.makeAttempt);

export default router;