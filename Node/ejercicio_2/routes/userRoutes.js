import { Router } from 'express';
import userController from '../controllers/userController.js';
export const router = Router();

import { validarJWT } from '../middlewares/validarJWT.js';
import { esUsuario } from '../middlewares/validarRoles.js';



// import controlador from  '../controllers/controlador.js'
// import { enLimite } from '../middlewares/middleware.js'


router.get('/',validarJWT, userController.usersGet);
router.get('/:id',validarJWT, userController.userGet);
router.post('/', userController.userPost);
router.delete('/:id',validarJWT, userController.userDelete);
router.put('/:id',validarJWT, userController.userPut);

export default router;

// router.get('/:id?', enLimite, controlador.funGetAt);
// router.post('/',controlador.funPost);
// router.post('/:id',controlador.funPostAt);
// router.delete('/:id', enLimite, controlador.funDelete);
// router.put('/:id',  enLimite, controlador.funPut);
